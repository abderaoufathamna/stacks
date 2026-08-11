@extends('layouts.app')
@section('title', 'My Profile — Stacks')
@section('content')
<span class="text-muted" style="font-family:'IBM Plex Mono', monospace; font-size:0.72rem; letter-spacing:0.1em; text-transform:uppercase;">Account</span>
<h3 style="margin-top:4px; margin-bottom:24px;">My Profile</h3>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<div style="display:grid; grid-template-columns: 1fr 1.4fr; gap:32px; max-width:760px;">

    {{-- Avatar --}}
    <div>
        <div style="width:100%; aspect-ratio:1/1; border:1px solid rgba(74,51,35,0.25); background:var(--coffee); display:flex; align-items:center; justify-content:center; overflow:hidden; margin-bottom:14px;">
            @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" data-cover-preview style="width:100%; height:100%; object-fit:cover;">
            @else
                <span style="font-family:'Fraunces', serif; font-size:3rem; color:var(--camel);">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
            @endif
        </div>
    </div>

    {{-- Forms --}}
    <div>
        {{-- Profile info form --}}
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
            </div>
            <div class="mb-3">
                <label>Profile Picture</label>
                <input type="file" name="avatar" class="form-control" accept="image/*">
                <p class="text-muted" style="font-size:0.78rem; margin-top:6px;">Leave empty to keep the current picture.</p>
            </div>
            <button class="btn btn-primary">Save changes</button>
        </form>

        <hr style="border:none; border-top:1px dashed rgba(74,51,35,0.25); margin:32px 0;">

        {{-- Password form --}}
        <h5 style="margin-bottom:16px;">Change Password</h5>
        <form method="POST" action="{{ route('profile.password') }}">
            @csrf
            <div class="mb-3">
                <label>Current Password</label>
                <input type="password" name="current_password" class="form-control">
            </div>
            <div class="mb-3">
                <label>New Password</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-3">
                <label>Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            <button class="btn btn-secondary">Update password</button>
        </form>
    </div>
</div>
@endsection