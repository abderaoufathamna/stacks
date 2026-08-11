@extends('layouts.app')
@section('content')
<h3>My Borrowed Books</h3>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Book</th>
            <th>Borrowed At</th>
            <th>Due Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($borrowings as $b)
        <tr>
            <td>{{ $b->book->title }}</td>
            <td>{{ $b->borrowed_at }}</td>
            <td>{{ $b->due_date }}</td>
            <td>
                @if($b->returned_at)
                    <span class="badge bg-success">Returned</span>
                @elseif(\Carbon\Carbon::parse($b->due_date)->isPast())
                    <span class="badge bg-danger">Overdue</span>
                @else
                    <span class="badge bg-warning text-dark">Borrowed</span>
                @endif
            </td>
            <td>
                @if(!$b->returned_at)
                <form action="{{ route('borrowings.return', $b) }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-primary">Return</button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection