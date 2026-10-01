@extends('layouts.app')

@section('title', 'Dictionary and language learning')

@section('content')
<div class="app-container dictionary-page" data-dictionary-search data-word-store-url="{{ route('words.store') }}" data-authenticated="{{ auth()->check() ? 'true' : 'false' }}">
    <div class="dictionary-topline"><div><p class="eyebrow">Your everyday language companion</p><h1>Find the word.<br><span>Feel the meaning.</span></h1><p class="page-subtitle">Definitions, pronunciation, examples, and the little details that make words stick.</p></div><div class="dictionary-stamp" aria-hidden="true"><i class="fas fa-spell-check"></i><span>LOOK IT<br>UP</span></div></div>

    <section class="lookup-panel" aria-labelledby="lookup-heading">
        <div class="lookup-label"><span class="lookup-dot"></span><span id="lookup-heading">Dictionary search</span><span class="lookup-mode">ENGLISH</span></div>
        <form id="word-search-form" class="lookup-form" role="search">
            <label for="word-search" class="visually-hidden">Search for an English word</label>
            <i class="fas fa-magnifying-glass" aria-hidden="true"></i>
            <input id="word-search" name="word" type="search" placeholder="Try ‘serendipity’ or ‘lucid’" autocomplete="off" aria-describedby="lookup-hint">
            <button class="btn btn-primary" type="submit">Search <i class="fas fa-arrow-right ms-2" aria-hidden="true"></i></button>
        </form>
        <div class="lookup-meta"><span id="lookup-hint">Press Enter to look up a word</span><span>Dictionary data via Free Dictionary API</span></div>
        <div id="lookup-status" class="lookup-status" aria-live="polite" role="status"></div>
        <div id="word-result" class="word-result" aria-live="polite"></div>
    </section>

    <div class="dictionary-columns">
        <section class="learning-feature">
            <div class="feature-art" role="img" aria-label="A reading desk with a book and notes"><span>WORD<br>OF THE<br>DAY</span><i class="fas fa-sun" aria-hidden="true"></i></div>
            <div class="feature-copy"><p class="eyebrow">A word to keep</p><h2>Make room for<br>new meaning.</h2><p>A fresh word, a pronunciation, and an example to carry into your day.</p><a href="{{ route('word-of-the-day') }}" class="text-link">Explore today's word <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i></a></div>
        </section>

        <section class="recent-panel">
            <div class="section-heading"><div><p class="eyebrow">Your trail</p><h2>Recent lookups</h2></div><button type="button" id="clear-history" class="text-button" title="Clear recent searches" aria-label="Clear recent searches"><i class="fas fa-trash-can" aria-hidden="true"></i></button></div>
            <ul id="recent-searches" class="recent-list"><li class="recent-empty">Words you look up will appear here.</li></ul>
        </section>
    </div>

    <section class="module-strip" aria-label="Learning modules">
        <a href="{{ route('grammar') }}"><span class="module-icon grammar-icon">Aa</span><span><strong>Grammar notes</strong><small>Patterns made clearer</small></span><i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
        <a href="{{ route('slang') }}"><span class="module-icon slang-icon">#</span><span><strong>Slang desk</strong><small>Language as it lives</small></span><i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
        <a href="{{ route('games') }}"><span class="module-icon games-icon"><i class="fas fa-table-cells" aria-hidden="true"></i></span><span><strong>Word games</strong><small>Practice by playing</small></span><i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
        <a href="{{ route('camera') }}"><span class="module-icon camera-icon"><i class="fas fa-hand" aria-hidden="true"></i></span><span><strong>Camera lab</strong><small>Touchless interaction study</small></span><i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
    </section>
</div>
@endsection
