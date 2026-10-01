@extends('layouts.app')

@section('title', 'Word games')

@section('content')
<div class="app-container module-page" data-wordle>
    <header class="page-heading"><div><p class="eyebrow">Vocabulary practice</p><h1>Five-letter word</h1><p class="page-subtitle">Guess the hidden word in six tries. Green is in the right place; gold belongs somewhere else.</p></div><button type="button" class="btn btn-outline-dark" id="new-word-game"><i class="fas fa-rotate-right me-2" aria-hidden="true"></i>New puzzle</button></header>
    <div class="wordle-layout">
        <section class="surface"><div class="surface-heading"><h2>The board</h2><span class="text-secondary small">6 guesses</span></div><div class="surface-body"><div class="wordle-board" id="wordle-board" aria-label="Word puzzle board"></div><p class="wordle-message" id="wordle-message" aria-live="polite"></p><form class="wordle-controls" id="wordle-form"><label class="visually-hidden" for="wordle-guess">Enter a five-letter guess</label><input id="wordle-guess" class="form-control" type="text" minlength="5" maxlength="5" pattern="[A-Za-z]{5}" autocomplete="off" aria-describedby="wordle-message" required><button class="btn btn-primary" type="submit">Guess</button></form></div></section>
        <aside class="surface"><div class="surface-heading"><h2>How to read the tiles</h2></div><div class="surface-body"><p><span class="badge bg-success">Green</span> The letter is correct and in the right position.</p><p><span class="badge bg-warning">Gold</span> The letter is in the word, but in another position.</p><p><span class="badge bg-secondary">Gray</span> The letter does not appear in the answer.</p><p class="mb-0 text-secondary small">This study prototype uses a small built-in answer set. The production proposal describes a larger curated vocabulary.</p></div></aside>
    </div>
</div>
@endsection