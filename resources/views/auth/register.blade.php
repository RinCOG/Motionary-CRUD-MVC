@extends('layouts.app')

@section('title', 'Create account')

@section('content')
<div class="app-container auth-wrap">
    <section class="auth-panel">
        <p class="eyebrow">Start tracking</p>
        <h1>Create your account</h1>
        <p class="auth-intro">Set up a private workspace for your inventory.</p>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3"><label for="name" class="form-label">Full name</label><input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" maxlength="255" required autofocus>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="mb-3"><label for="email" class="form-label">Email address</label><input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" required>@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="mb-3"><label for="password" class="form-label">Password</label><input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password" required>@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="mb-4"><label for="password-confirm" class="form-label">Confirm password</label><input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password" required></div>
            <button type="submit" class="btn btn-primary w-100 py-2">Create account <i class="fas fa-arrow-right ms-2" aria-hidden="true"></i></button>
        </form>
        <p class="auth-footnote">Already registered? <a href="{{ route('login') }}">Sign in</a></p>
    </section>
</div>
@endsection
