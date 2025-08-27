<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\BookShelf;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::with(['author', 'category', 'bookShelf', 'publisher']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('isbn', 'like', '%' . $request->search . '%')
                  ->orWhere('barcode', 'like', '%' . $request->search . '%')
                  ->orWhereHas('author', function ($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->shelf_id) {
            $query->where('book_shelf_id', $request->shelf_id);
        }

        $books = $query->latest()->paginate(15);

        $categories = Category::all();
        $shelves = BookShelf::all();

        return Inertia::render('books/index', [
            'books' => $books,
            'categories' => $categories,
            'shelves' => $shelves,
            'filters' => $request->only(['search', 'category_id', 'shelf_id']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('books/create', [
            'authors' => Author::all(),
            'categories' => Category::all(),
            'publishers' => Publisher::all(),
            'shelves' => BookShelf::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $book = Book::create($request->validated());

        return redirect()->route('books.show', $book)
            ->with('success', 'Book created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book->load(['author', 'category', 'bookShelf', 'publisher', 'transactions.member']);

        return Inertia::render('books/show', [
            'book' => $book,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return Inertia::render('books/edit', [
            'book' => $book,
            'authors' => Author::all(),
            'categories' => Category::all(),
            'publishers' => Publisher::all(),
            'shelves' => BookShelf::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->validated());

        return redirect()->route('books.show', $book)
            ->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully.');
    }
}