<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBorrowRequest;
use App\Http\Requests\StoreReturnRequest;
use App\Models\AppSetting;
use App\Models\Book;
use App\Models\Member;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transaction::with(['member', 'book', 'borrowedBy', 'returnedBy']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('transaction_code', 'like', '%' . $request->search . '%')
                  ->orWhereHas('member', function ($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  })
                  ->orWhereHas('book', function ($q) use ($request) {
                      $q->where('title', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $transactions = $query->latest()->paginate(15);

        return Inertia::render('transactions/index', [
            'transactions' => $transactions,
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    /**
     * Show the form for creating a new resource (borrowing).
     */
    public function create()
    {
        return Inertia::render('transactions/create', [
            'loan_days' => AppSetting::get('default_loan_days', 7),
        ]);
    }

    /**
     * Store a newly created resource in storage (process borrowing).
     */
    public function store(StoreBorrowRequest $request)
    {
        $member = Member::where('barcode', $request->member_barcode)
            ->orWhere('member_code', $request->member_barcode)
            ->first();

        if (!$member) {
            return back()->withErrors(['member_barcode' => 'Member not found.']);
        }

        if ($member->status !== 'active') {
            return back()->withErrors(['member_barcode' => 'Member is not active.']);
        }

        $book = Book::where('barcode', $request->book_barcode)->first();

        if (!$book) {
            return back()->withErrors(['book_barcode' => 'Book not found.']);
        }

        if ($book->available_quantity <= 0) {
            return back()->withErrors(['book_barcode' => 'Book is not available.']);
        }

        $loanDays = AppSetting::get('default_loan_days', 7);
        $dueDate = now()->addDays($loanDays);

        $transaction = Transaction::create([
            'member_id' => $member->id,
            'book_id' => $book->id,
            'borrowed_by' => auth()->id(),
            'borrowed_date' => now(),
            'due_date' => $dueDate,
            'status' => 'borrowed',
        ]);

        // Update book availability
        $book->decrement('available_quantity');

        return redirect()->route('transactions.show', $transaction)
            ->with('success', 'Book borrowed successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['member', 'book', 'borrowedBy', 'returnedBy']);

        return Inertia::render('transactions/show', [
            'transaction' => $transaction,
        ]);
    }

    /**
     * Show the form for returning a book.
     */
    public function edit(Transaction $transaction)
    {
        if ($transaction->status !== 'borrowed') {
            return back()->withErrors(['error' => 'This book has already been returned.']);
        }

        return Inertia::render('transactions/return', [
            'transaction' => $transaction->load(['member', 'book']),
        ]);
    }

    /**
     * Update the specified resource in storage (process return).
     */
    public function update(StoreReturnRequest $request, Transaction $transaction)
    {
        if ($transaction->status !== 'borrowed') {
            return back()->withErrors(['error' => 'This book has already been returned.']);
        }

        $returnDate = now();
        $fineAmount = 0;

        // Calculate fine if overdue
        if ($returnDate->gt($transaction->due_date)) {
            $overdueDays = $returnDate->diffInDays($transaction->due_date);
            $finePerDay = AppSetting::get('fine_per_day', 1000);
            $fineAmount = $overdueDays * $finePerDay;
        }

        $transaction->update([
            'returned_date' => $returnDate,
            'returned_by' => auth()->id(),
            'status' => 'returned',
            'fine_amount' => $fineAmount,
            'notes' => $request->notes,
        ]);

        // Update book availability
        $transaction->book->increment('available_quantity');

        return redirect()->route('transactions.show', $transaction)
            ->with('success', 'Book returned successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        // Only allow deletion of returned transactions
        if ($transaction->status === 'borrowed') {
            return back()->withErrors(['error' => 'Cannot delete active borrowing transaction.']);
        }

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }
}