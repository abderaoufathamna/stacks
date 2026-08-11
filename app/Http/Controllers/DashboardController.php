<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Keep this in sync with whatever limit you enforce in BorrowingController
    const MAX_ACTIVE_BORROWS = 2;

    public function index()
    {
        $stats = null;
        $member = null;

        if (Auth::user()->isAdmin()) {
            $stats = [
                'total_books'      => Book::count(),
                'total_copies'     => Book::sum('total_copies'),
                'borrowed_now'     => Borrowing::whereNull('returned_at')->count(),
                'overdue'          => Borrowing::whereNull('returned_at')
                                        ->where('due_date', '<', now())
                                        ->count(),
                'total_members'    => User::where('role', 'user')->count(),
                'recent_borrowings'=> Borrowing::with('book', 'user')
                                        ->latest()
                                        ->take(5)
                                        ->get(),
            ];
        } else {
            $activeBorrowings = Borrowing::with('book')
                ->where('user_id', Auth::id())
                ->whereNull('returned_at')
                ->latest()
                ->get();

            $member = [
                'active_borrowings' => $activeBorrowings,
                'slots_used'        => $activeBorrowings->count(),
                'slots_max'         => self::MAX_ACTIVE_BORROWS,
                'total_ever'        => Borrowing::where('user_id', Auth::id())->count(),
                'overdue_count'     => $activeBorrowings->filter(
                                            fn ($b) => \Carbon\Carbon::parse($b->due_date)->isPast()
                                        )->count(),
                'discover' => Book::with('author', 'category')
                                ->where('available_copies', '>', 0)
                                ->latest()
                                ->take(4)
                                ->get(),
            ];
        }

        return view('dashboard', compact('stats', 'member'));
    }
}