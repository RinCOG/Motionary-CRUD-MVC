@extends('layouts.app')

@section('title', 'My wordbook')

@section('content')
<div class="app-container">
    <header class="page-heading"><div><p class="eyebrow">Your saved vocabulary</p><h1>My wordbook</h1><p class="page-subtitle">Definitions worth keeping, all in one personal collection.</p></div><a href="{{ route('words.create') }}" class="btn btn-primary px-3 py-2"><i class="fas fa-plus me-2" aria-hidden="true"></i>Add a word</a></header>
    <section class="surface">
        <form method="GET" action="{{ route('words.index') }}" class="filter-bar" role="search"><div class="search-field"><label class="visually-hidden" for="q">Find a saved word</label><input id="q" name="q" type="search" class="form-control" value="{{ $search }}" placeholder="Find a saved word"></div><button type="submit" class="btn btn-primary px-3"><i class="fas fa-magnifying-glass me-2" aria-hidden="true"></i>Search</button></form>
        <div class="surface-heading"><h2>Saved entries</h2><span class="text-secondary small">{{ $words->total() }} words</span></div>
        @forelse($words as $word)
            <article class="wordbook-item"><div class="d-flex justify-content-between gap-3"><div><h2><a class="product-name" href="{{ route('words.show', $word) }}">{{ $word->term }}</a></h2><span class="phonetic-text">{{ $word->phonetic }}@if($word->part_of_speech) · {{ $word->part_of_speech }}@endif</span><p>{{ Str::limit($word->definition, 220) }}</p></div><a href="{{ route('words.edit', $word) }}" class="action-icon align-self-start" title="Edit {{ $word->term }}" aria-label="Edit {{ $word->term }}"><i class="fas fa-pen" aria-hidden="true"></i></a></div></article>
        @empty
            <div class="empty-state">No saved words yet. Use dictionary search and save an entry, or add one here.</div>
        @endforelse
        <div class="surface-body">{{ $words->links() }}</div>
    </section>
</div>
@endsection