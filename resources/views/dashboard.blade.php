@extends('layouts.app')
@section('title', 'Dashboard — Stacks')
@section('content')
<span class="text-muted" style="font-family:'IBM Plex Mono', monospace; font-size:0.72rem; letter-spacing:0.1em; text-transform:uppercase;">Dashboard</span>
<h3 class="mt-4" style="margin-top:8px;">Welcome, {{ auth()->user()->name }}</h3>

@if($stats)
    {{-- =========================== ADMIN VIEW =========================== --}}
    <p class="text-muted" style="margin-bottom:8px;">Here's how the shelves are doing today.</p>

    <div class="d-flex" style="gap:14px; flex-wrap:wrap; margin-top:20px;">
        <a href="{{ route('books.index') }}" class="btn btn-primary">Browse Books</a>
        <a href="{{ route('borrowings.index') }}" class="btn btn-secondary">My Borrowings</a>
        <a href="{{ route('authors.index') }}" class="btn btn-secondary">Manage Authors</a>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Manage Categories</a>
    </div>

    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-label">Total Books</div>
            <div class="stat-num" data-count="{{ $stats['total_books'] }}">0</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Copies</div>
            <div class="stat-num" data-count="{{ $stats['total_copies'] }}">0</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Borrowed Now</div>
            <div class="stat-num" data-count="{{ $stats['borrowed_now'] }}">0</div>
        </div>
        <div class="stat-card {{ $stats['overdue'] > 0 ? 'alert-stat' : '' }}">
            <div class="stat-label">Overdue</div>
            <div class="stat-num" data-count="{{ $stats['overdue'] }}">0</div>
        </div>
    </div>

    <h5 style="margin-bottom:14px;">Recent Borrowings</h5>
    <div class="recent-list mb-3">
        @forelse($stats['recent_borrowings'] as $b)
            <div class="recent-row">
                <div>
                    <div class="recent-title">{{ $b->book->title }}</div>
                    <div class="recent-meta">{{ $b->user->name }} · due {{ \Carbon\Carbon::parse($b->due_date)->format('M d, Y') }}</div>
                </div>
                <div>
                    @if($b->returned_at)
                        <span class="badge bg-success">Returned</span>
                    @elseif(\Carbon\Carbon::parse($b->due_date)->isPast())
                        <span class="badge bg-danger">Overdue</span>
                    @else
                        <span class="badge bg-warning text-dark">Borrowed</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="recent-row"><span class="text-muted">No borrowings yet.</span></div>
        @endforelse
    </div>

@else
    {{-- =========================== MEMBER VIEW =========================== --}}
    <p class="text-muted" style="margin-bottom:28px;">
        @if($member['overdue_count'] > 0)
            You have {{ $member['overdue_count'] }} overdue {{ Str::plural('book', $member['overdue_count']) }} — return {{ $member['overdue_count'] > 1 ? 'them' : 'it' }} when you can.
        @elseif($member['slots_used'] > 0)
            You're currently reading {{ $member['slots_used'] }} {{ Str::plural('book', $member['slots_used']) }}.
        @else
            Your shelf is empty — go find something good to read.
        @endif
    </p>

    <div class="member-grid">
        {{-- Currently borrowed --}}
        <div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 style="margin:0;">Currently Reading</h5>
                <span class="slot-indicator">
                    @for($i = 0; $i < $member['slots_max']; $i++)
                        <span class="slot-dot {{ $i < $member['slots_used'] ? 'filled' : '' }}"></span>
                    @endfor
                    {{ $member['slots_used'] }}/{{ $member['slots_max'] }} slots used
                </span>
            </div>

            @if($member['active_borrowings']->isEmpty())
                <div class="empty-shelf">
                    <div class="empty-shelf-icon">📖</div>
                    <p>You haven't borrowed anything yet.</p>
                    <a href="{{ route('books.index') }}" class="btn btn-primary btn-sm">Browse the catalogue</a>
                </div>
            @else
                <div class="member-book-list">
                    @foreach($member['active_borrowings'] as $b)
                        @php $isOverdue = \Carbon\Carbon::parse($b->due_date)->isPast(); @endphp
                        <div class="member-book-row {{ $isOverdue ? 'is-overdue' : '' }}">
                            <div class="member-book-cover" @if($b->book->cover_image) style="background-image:url('{{ asset('storage/' . $b->book->cover_image) }}');" @endif></div>
                            <div style="flex:1;">
                                <div class="member-book-title">{{ $b->book->title }}</div>
                                <div class="member-book-due">
                                    @if($isOverdue)
                                        <span class="badge bg-danger">Overdue</span> was due {{ \Carbon\Carbon::parse($b->due_date)->format('M d, Y') }}
                                    @else
                                        Due {{ \Carbon\Carbon::parse($b->due_date)->format('M d, Y') }} · {{ (int) now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($b->due_date)->startOfDay(), false) }} days left
                                    @endif
                                </div>
                            </div>
                            <form action="{{ route('borrowings.return', $b) }}" method="POST">
                                @csrf
                                <button class="btn btn-sm btn-secondary">Return</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif

            @if($member['slots_used'] >= $member['slots_max'])
                <p class="text-muted" style="font-size:0.82rem; margin-top:14px;">
                    You've reached the {{ $member['slots_max'] }}-book limit. Return a book to borrow another.
                </p>
            @endif
        </div>

        {{-- Discover --}}
        <div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 style="margin:0;">Discover</h5>
                <a href="{{ route('books.index') }}" style="font-size:0.82rem;">See all →</a>
            </div>

            @if($member['discover']->isEmpty())
                <p class="text-muted" style="font-size:0.88rem;">No books available right now.</p>
            @else
                <div class="discover-grid">
                    @foreach($member['discover'] as $book)
                        <div class="discover-card">
                            <div class="discover-cover" @if($book->cover_image) style="background-image:url('{{ asset('storage/' . $book->cover_image) }}');" @endif></div>
                            <div class="discover-title">{{ $book->title }}</div>
                            <div class="discover-author">{{ $book->author->name }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endif
@endsection