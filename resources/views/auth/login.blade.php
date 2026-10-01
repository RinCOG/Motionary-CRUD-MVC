@extends('layouts.app')

@section('title', 'Sign in')

@section('content')
<div class="app-container auth-wrap">
    <section class="auth-panel">
        <p class="eyebrow">Welcome back</p>
        <h1>Sign in to Stockroom</h1>
        <p class="auth-intro">Continue to your inventory workspace.</p>
        @if(session('status'))<div class="alert alert-success" role="status">{{ session('status') }}</div>@endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3"><label for="email" class="form-label">Email address</label><input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" required autofocus>@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="mb-3"><label for="password" class="form-label">Password</label><input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password" required>@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="d-flex align-items-center justify-content-between mb-4"><label class="form-check-label"><input class="form-check-input me-2" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>Remember me</label>@if(Route::has('password.request'))<a href="{{ route('password.request') }}" class="small">Forgot password?</a>@endif</div>
            <button type="submit" class="btn btn-primary w-100 py-2">Sign in <i class="fas fa-arrow-right ms-2" aria-hidden="true"></i></button>
        </form>
        <p class="auth-footnote">New to Stockroom? <a href="{{ route('register') }}">Create an account</a></p>
    </section>
</div>
@endsection
