<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $stats = [
            'total_books' => Book::count(),
            'available_books' => Book::sum('available_quantity'),
            'total_members' => Member::active()->count(),
            'borrowed_books' => Transaction::borrowed()->count(),
            'overdue_books' => Transaction::overdue()->count(),
        ];

        $recentTransactions = Transaction::with(['member', 'book', 'borrowedBy'])
            ->latest()
            ->limit(10)
            ->get();

        return Inertia::render('dashboard', [
            'stats' => $stats,
            'recent_transactions' => $recentTransactions,
        ]);
    }
}