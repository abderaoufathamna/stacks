@extends('layouts.app')
@section('title', 'Add Book — Stacks')
@section('content')
<span class="text-muted" style="font-family:'IBM Plex Mono', monospace; font-size:0.72rem; letter-spacing:0.1em; text-transform:uppercase;">Catalogue</span>
<h3 style="margin-top:4px; margin-bottom:24px;">Add Book</h3>

<form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data" style="max-width:480px;">
    @csrf
    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title') }}">
        @error('title') <p class="text-danger">{{ $message }}</p> @enderror
    </div>
    <div class="mb-3">
        <label>Author</label>
        <select name="author_id" class="form-control">
            @foreach($authors as $author)
                <option value="{{ $author->id }}">{{ $author->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Category</label>
        <select name="category_id" class="form-control">
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Total Copies</label>
        <input type="number" name="total_copies" class="form-control" value="1" min="1">
    </div>
    <div class="mb-3">
        <label>Cover Image</label>
        <input type="file" name="cover_image" class="form-control" accept="image/*">
        @error('cover_image') <p class="text-danger">{{ $message }}</p> @enderror
    </div>
    <button class="btn btn-primary">Save</button>
    <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection