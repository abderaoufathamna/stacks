@extends('layouts.app')
@section('content')
<h3>Categories</h3>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('categories.store') }}" class="d-flex mb-3">
    @csrf
    <input type="text" name="name" class="form-control me-2" placeholder="Category name" required>
    <button class="btn btn-primary">Add</button>
</form>

<table class="table table-bordered">
    <thead><tr><th>Name</th><th>Action</th></tr></thead>
    <tbody>
        @foreach($categories as $category)
        <tr>
            <td>{{ $category->name }}</td>
            <td>
                <form action="{{ route('categories.destroy', $category) }}" method="POST">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection