<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with('book')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('borrowings.index', compact('borrowings'));
    }

    public function borrow(Book $book)
    {
        if ($book->available_copies < 1) {
            return back()->with('error', 'No copies available right now');
        }

        $hasActiveBorrowing = Borrowing::where('user_id', auth()->id())
                                                        ->whereNull('returned_at')
                                                        ->count();

        if ($hasActiveBorrowing >= 2)
        {
            return back()->with('error', 'You can only borrow \'2\' books at a time.');
        }
        Borrowing::create([
            'book_id' => $book->id,
            'user_id' => Auth::id(),
            'borrowed_at' => now(),
            'due_date' => now()->addDays(14),
        ]);

        $book->decrement('available_copies');

        return back()->with('success', 'Book borrowed successfully. Due in 14 days.');
    }

    public function returnBook(Borrowing $borrowing)
    {
        if ($borrowing->returned_at) {
            return back()->with('error', 'This book was already returned');
        }

        $borrowing->update(['returned_at' => now()]);
        $borrowing->book->increment('available_copies');

        return back()->with('success', 'Book returned successfully');
    }
}