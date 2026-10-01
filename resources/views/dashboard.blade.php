@extends('layouts.app')

@section('title', 'Learner dashboard')

@section('content')
<div class="app-container">
    <header class="page-heading">
        <div><p class="eyebrow">Your learning space</p><h1>Welcome back, {{ Auth::user()->name }}.</h1><p class="page-subtitle">Pick up where your curiosity left off.</p></div>
        <a href="{{ route('home') }}#word-search" class="btn btn-primary px-3 py-2"><i class="fas fa-magnifying-glass me-2" aria-hidden="true"></i>Look up a word</a>
    </header>

    <section class="stats-grid" aria-label="Learning summary">
        <article class="stat-card"><div class="stat-label">Saved words <span class="stat-icon"><i class="fas fa-bookmark" aria-hidden="true"></i></span></div><strong class="stat-value">{{ number_format($wordCount) }}</strong><span class="stat-note">In your personal wordbook</span></article>
        <article class="stat-card"><div class="stat-label">Latest word <span class="stat-icon"><i class="fas fa-clock-rotate-left" aria-hidden="true"></i></span></div><strong class="stat-value stat-word">{{ $recentWord ?? '—' }}</strong><span class="stat-note">Most recently saved</span></article>
        <article class="stat-card"><div class="stat-label">Learning modules <span class="stat-icon"><i class="fas fa-shapes" aria-hidden="true"></i></span></div><strong class="stat-value">04</strong><span class="stat-note">Grammar, slang, wordplay, camera lab</span></article>
        <article class="stat-card"><div class="stat-label">Today's word <span class="stat-icon"><i class="fas fa-sun" aria-hidden="true"></i></span></div><strong class="stat-value">{{ now()->format('M j') }}</strong><span class="stat-note"><a href="{{ route('word-of-the-day') }}">Open the daily feature</a></span></article>
    </section>

    <div class="dashboard-grid">
        <section class="surface">
            <div class="surface-heading"><h2>Recently saved</h2><a href="{{ route('words.index') }}">Open wordbook <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i></a></div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead><tr><th>Word</th><th>Part of speech</th><th>Pronunciation</th><th>Added</th></tr></thead>
                    <tbody>
                        @forelse($words as $word)
                            <tr>
                                <td><a class="product-name" href="{{ route('words.show', $word) }}">{{ $word->term }}</a></td>
                                <td>{{ $word->part_of_speech ?? '—' }}</td>
                                <td class="phonetic-text">{{ $word->phonetic ?? '—' }}</td>
                                <td>{{ $word->created_at->format('M d') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="empty-state">Your wordbook is empty. Look up a word and save it for later.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <aside class="stock-callout">
            <p class="eyebrow">A daily nudge</p>
            <h2>Let one new word<br>stay with you.</h2>
            <p>Explore its meaning, hear how it sounds, and add it to your own collection.</p>
            <span class="stock-number"><i class="fas fa-book-open" aria-hidden="true"></i></span>
            <a href="{{ route('word-of-the-day') }}" class="btn btn-success w-100">See today's word</a>
        </aside>
    </div>
</div>
@endsection
