@extends('layouts.app')
@section('title', 'Sign in — Stacks')
@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <div class="eyebrow">Members &amp; admins</div>
        <h3>Sign in</h3>

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            <div class="field">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="field">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            @error('email') <p class="text-danger">{{ $message }}</p> @enderror

            <button class="btn btn-primary">Sign in</button>
        </form>

        <div class="switch-link">
            Don't have an account? <a href="{{ route('register') }}">Create one</a>
        </div>
    </div>
</div>
@endsection
