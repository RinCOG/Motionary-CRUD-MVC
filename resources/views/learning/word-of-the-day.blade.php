@extends('layouts.app')

@section('title', 'Word of the day')

@section('content')
<div class="app-container module-page">
    <header class="page-heading"><div><p class="eyebrow">A little language ritual</p><h1>Word of the day</h1><p class="page-subtitle">One word, explored slowly enough to remember.</p></div><a href="{{ route('home', ['word' => $word[0]]) }}#word-search" class="btn btn-outline-dark px-3 py-2">Look it up <i class="fas fa-arrow-right ms-2" aria-hidden="true"></i></a></header>
    <section class="module-hero">
        <div><p class="eyebrow">{{ now()->format('l, F j') }}</p><h1>{{ $word[0] }}</h1><p class="phonetic-text">{{ $word[2] }}</p><p>{{ $word[3] }}</p></div>
        <aside class="daily-word-card"><span class="part-of-speech">{{ $word[1] }}</span><p class="eyebrow">In a sentence</p><p>“{{ $word[4] }}”</p><button type="button" class="btn btn-success mt-3 align-self-start" data-speak-word="{{ $word[0] }}"><i class="fas fa-volume-high me-2" aria-hidden="true"></i>Hear the word</button></aside>
    </section>
    <div class="d-flex flex-wrap gap-2"><a href="{{ route('grammar') }}" class="btn btn-outline-dark">Browse grammar notes</a><a href="{{ route('games') }}" class="btn btn-primary">Practice with a word game</a></div>
</div>
@endsection