@extends('layouts.app')

@section('title', 'About Motionary')

@section('content')
<div class="app-container">
    <header class="page-heading"><div><p class="eyebrow">The proposed study</p><h1>Words, made more accessible.</h1><p class="page-subtitle">Motionary explores how event-driven interaction and computer vision could make dictionary-based learning more inclusive.</p></div></header>

    <section class="story-layout">
        <div class="story-mark"><i class="fas fa-hand-sparkles" aria-hidden="true"></i><strong>Learn with<br>your hands<br>free.</strong></div>
        <div class="story-copy">
            <h2>Learning without the extra reach</h2>
            <p>Motionary is a touchless, event-driven web dictionary and language-learning platform proposed by Sherwin Carbonilla, Kenneth Dela Torre, and Andrei Joaquin Demano. It combines lexical lookup with pronunciation, examples, grammar notes, slang, and vocabulary games.</p>
            <p>The study explores an optional camera-based hand-navigation layer alongside ordinary keyboard and mouse input. Its intended vision pipeline runs on the learner's device, translating recognized gestures into interface events rather than sending camera frames to a server.</p>
            <div class="principle-list">
                <article class="principle"><h2><i class="fas fa-bolt me-2 text-success" aria-hidden="true"></i>Event-driven</h2><p>Asynchronous events connect input and interface responses with loose coupling.</p></article>
                <article class="principle"><h2><i class="fas fa-eye me-2 text-success" aria-hidden="true"></i>On-device vision</h2><p>Hand tracking is designed to run locally, with explicit camera permission.</p></article>
                <article class="principle"><h2><i class="fas fa-universal-access me-2 text-success" aria-hidden="true"></i>Inclusive by design</h2><p>Touchless controls supplement, never replace, familiar input methods.</p></article>
            </div>
            <p class="study-note"><strong>Implementation note:</strong> This Laravel version demonstrates the dictionary, learning modules, and persisted wordbook. Full MediaPipe hand-landmark recognition and the React architecture described in the proposal remain future implementation work.</p>
        </div>
    </section>
</div>
@endsection
