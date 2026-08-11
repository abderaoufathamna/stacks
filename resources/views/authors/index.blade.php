@extends('layouts.app')
@section('content')
<h3>Authors</h3>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('authors.store') }}" class="d-flex mb-3">
    @csrf
    <input type="text" name="name" class="form-control me-2" placeholder="Author name" required>
    <button class="btn btn-primary">Add</button>
</form>

<table class="table table-bordered">
    <thead><tr><th>Name</th><th>Action</th></tr></thead>
    <tbody>
        @foreach($authors as $author)
        <tr>
            <td>{{ $author->name }}</td>
            <td>
                <form action="{{ route('authors.destroy', $author) }}" method="POST">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this author?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection