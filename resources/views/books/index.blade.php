@extends('layouts.app')
@section('title', 'Books — Stacks')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <span class="text-muted" style="font-family:'IBM Plex Mono', monospace; font-size:0.72rem; letter-spacing:0.1em; text-transform:uppercase;">Catalogue</span>
        <h3 style="margin-top:4px;">Books</h3>
    </div>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('books.create') }}" class="btn btn-primary">+ Add Book</a>
    @endif
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="books-layout">
    {{-- Sidebar --}}
    <aside class="books-sidebar">
        <div class="sidebar-block">
            <div class="sidebar-title">Search</div>
            <input type="text" data-book-search placeholder="Title or author…" class="form-control" style="font-size:0.85rem; padding:8px 10px;">
        </div>

        <div class="sidebar-block">
            <div class="sidebar-title">Sort</div>
            <a href="{{ route('books.index', array_merge(request()->except(['sort', 'page']), ['sort' => 'title'])) }}"
               class="sidebar-link {{ request('sort', 'title') === 'title' ? 'active' : '' }}">
                All Books
            </a>
            <a href="{{ route('books.index', array_merge(request()->except(['sort', 'page']), ['sort' => 'latest'])) }}"
               class="sidebar-link {{ request('sort') === 'latest' ? 'active' : '' }}">
                Latest Additions
            </a>
        </div>

        <div class="sidebar-block">
            <div class="sidebar-title">Categories</div>
            <a href="{{ route('books.index', array_merge(request()->except(['category', 'page']))) }}"
               class="sidebar-link {{ !request('category') ? 'active' : '' }}">
                <span>All Categories</span>
                <span class="sidebar-count">{{ $categories->sum('books_count') }}</span>
            </a>
            @foreach($categories as $category)
                <a href="{{ route('books.index', array_merge(request()->except(['category', 'page']), ['category' => $category->id])) }}"
                   class="sidebar-link {{ request('category') == $category->id ? 'active' : '' }}">
                    <span>{{ $category->name }}</span>
                    <span class="sidebar-count">{{ $category->books_count }}</span>
                </a>
            @endforeach
        </div>
    </aside>

    {{-- Book grid --}}
    <div>
        @if($books->isEmpty())
            <p class="text-muted">No books found for this filter.</p>
        @else
        <div class="book-grid">
            @foreach($books as $book)
            <div class="book-card">
                <div class="book-cover" @if($book->cover_image) style="background-image:url('{{ asset('storage/' . $book->cover_image) }}');" @endif></div>
                <div class="book-card-body">
                    <div class="book-callnum">{{ $book->category->name }}</div>
                    <h4>{{ $book->title }}</h4>
                    <div class="book-author">{{ $book->author->name }}</div>

                    <div class="book-meta-row">
                        @if($book->available_copies > 0)
                            <span class="badge bg-success">{{ $book->available_copies }} available</span>
                        @else
                            <span class="badge bg-danger">Not available</span>
                        @endif
                        <span class="book-copies">{{ $book->total_copies }} total</span>
                    </div>

                    <div class="book-actions">
                        @if($book->available_copies > 0)
                            <form action="{{ route('books.borrow', $book) }}" method="POST">
                                @csrf
                                <button class="btn btn-sm btn-success">Borrow</button>
                            </form>
                        @endif

                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('books.edit', $book) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('books.destroy', $book) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{ $books->links() }}
        @endif
    </div>
</div>
@endsection