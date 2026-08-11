@extends('layouts.app')
@section('title', 'Create account — Stacks')
@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <div class="eyebrow">Join the library</div>
        <h3>Create account</h3>

        <form method="POST" action="{{ route('register.submit') }}">
            @csrf
            <div class="field">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
            </div>
            <div class="field">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="field">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="field">
                <label>Confirm password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            @error('email') <p class="text-danger">{{ $message }}</p> @enderror

            <button class="btn btn-primary">Register</button>
        </form>

        <div class="switch-link">
            Already have an account? <a href="{{ route('login') }}">Sign in</a>
        </div>
    </div>
</div>
@endsection
