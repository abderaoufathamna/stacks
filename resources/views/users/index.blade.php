@extends('layouts.app')
@section('title', 'Users — Stacks')
@section('content')
<span class="text-muted" style="font-family:'IBM Plex Mono', monospace; font-size:0.72rem; letter-spacing:0.1em; text-transform:uppercase;">Administration</span>
<h3 style="margin-top:4px; margin-bottom:24px;">Users</h3>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Joined</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>
                {{ $user->name }}
                @if($user->id === auth()->id())
                    <span class="text-muted" style="font-size:0.78rem;">(you)</span>
                @endif
            </td>
            <td>{{ $user->email }}</td>
            <td>
                @if($user->role === 'admin')
                    <span class="badge bg-warning text-dark">Admin</span>
                @else
                    <span class="badge bg-success">Member</span>
                @endif
            </td>
            <td>{{ $user->created_at->format('M d, Y') }}</td>
            <td>
                @if($user->id !== auth()->id())
                    <form action="{{ route('users.toggleRole', $user) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-secondary">
                            {{ $user->role === 'admin' ? 'Make member' : 'Make admin' }}
                        </button>
                    </form>
                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">Delete</button>
                    </form>
                @else
                    <span class="text-muted" style="font-size:0.82rem;">—</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $users->links() }}
@endsection