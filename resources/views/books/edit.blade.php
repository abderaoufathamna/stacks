@extends('layouts.app')
@section('title', 'Edit Book — Stacks')
@section('content')
<span class="text-muted" style="font-family:'IBM Plex Mono', monospace; font-size:0.72rem; letter-spacing:0.1em; text-transform:uppercase;">Catalogue</span>
<h3 style="margin-top:4px; margin-bottom:24px;">Edit Book</h3>

<form method="POST" action="{{ route('books.update', $book) }}" enctype="multipart/form-data" style="max-width:480px;">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control" value="{{ $book->title }}">
        @error('title') <p class="text-danger">{{ $message }}</p> @enderror
    </div>
    <div class="mb-3">
        <label>Author</label>
        <select name="author_id" class="form-control">
            @foreach($authors as $author)
                <option value="{{ $author->id }}" {{ $book->author_id == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Category</label>
        <select name="category_id" class="form-control">
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $book->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Total Copies</label>
        <input type="number" name="total_copies" class="form-control" value="{{ $book->total_copies }}" min="1">
    </div>

    <div class="mb-3">
        <label>Cover Image</label>

        @if($book->cover_image)
            <div style="margin-bottom:10px;">
                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" data-cover-preview style="width:110px; aspect-ratio:3/4; object-fit:cover; border:1px solid rgba(74,51,35,0.25);">
            </div>
        @endif

        <input type="file" name="cover_image" class="form-control" accept="image/*">
        <p class="text-muted" style="font-size:0.78rem; margin-top:6px;">Leave empty to keep the current image.</p>
        @error('cover_image') <p class="text-danger">{{ $message }}</p> @enderror
    </div>

    <button class="btn btn-primary">Update</button>
    <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection