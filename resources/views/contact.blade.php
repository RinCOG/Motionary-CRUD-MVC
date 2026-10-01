@extends('layouts.app')

@section('title', 'Contact')

@section('content')
<div class="app-container">
    <header class="page-heading"><div><p class="eyebrow">Questions or feedback</p><h1>Get in touch.</h1><p class="page-subtitle">Share a note about the inventory system or the study behind it.</p></div></header>

    <div class="contact-layout">
        <aside class="contact-aside">
            <p class="eyebrow">Motionary study</p>
            <h2>Share a thought.</h2>
            <p>Questions about the dictionary concept, the gesture interaction study, or the current prototype are welcome.</p>
            <span class="d-block mt-4 text-white-50"><i class="fas fa-lock me-2 text-success" aria-hidden="true"></i>No account needed to send a note</span>
        </aside>
        <section class="surface">
            <div class="surface-heading"><h2>Send a message</h2></div>
            <div class="surface-body">
                <form method="POST" action="{{ route('contact.store') }}">
                    @csrf
                    <div class="mb-3"><label for="name" class="form-label">Name</label><input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" autocomplete="name" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-3"><label for="email" class="form-label">Email</label><input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" autocomplete="email" required>@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="mb-3"><label for="message" class="form-label">Message</label><textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" required>{{ old('message') }}</textarea>@error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <button type="submit" class="btn btn-primary px-4 py-2"><i class="fas fa-paper-plane me-2" aria-hidden="true"></i>Send message</button>
                </form>
            </div>
        </section>
    </div>
</div>
@endsection
