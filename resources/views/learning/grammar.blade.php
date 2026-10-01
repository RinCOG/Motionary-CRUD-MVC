@extends('layouts.app')

@section('title', 'Grammar notes')

@section('content')
<div class="app-container module-page">
    <header class="page-heading"><div><p class="eyebrow">A practical grammar shelf</p><h1>Grammar notes</h1><p class="page-subtitle">Short comparisons for patterns that often sound alike.</p></div></header>
    <section class="learning-grid">
        <article class="learning-card"><p class="eyebrow">Word choice</p><h2>“Affect” and “effect”</h2><p><strong>Affect</strong> is usually a verb meaning to influence. <strong>Effect</strong> is usually a noun meaning a result.</p><p class="example-line">The weather can affect plans. The effect was a quieter afternoon.</p></article>
        <article class="learning-card"><p class="eyebrow">Punctuation</p><h2>“Its” and “it’s”</h2><p><strong>Its</strong> shows possession. <strong>It’s</strong> contracts “it is” or “it has.”</p><p class="example-line">The book lost its cover. It’s still readable.</p></article>
        <article class="learning-card"><p class="eyebrow">Sentence craft</p><h2>Keep parallel forms</h2><p>Use the same grammatical structure for items in a series to make the sentence easier to follow.</p><p class="example-line">She enjoys reading, writing, and drawing.</p></article>
        <article class="learning-card"><p class="eyebrow">Agreement</p><h2>Subject and verb</h2><p>A singular subject usually takes a singular verb; a plural subject takes a plural verb.</p><p class="example-line">The learner studies each day. The learners study together.</p></article>
        <article class="learning-card"><p class="eyebrow">Clarity</p><h2>Place modifiers carefully</h2><p>Keep descriptive phrases close to the word they modify to avoid accidental ambiguity.</p><p class="example-line">She almost read every chapter. She read almost every chapter.</p></article>
        <article class="learning-card"><p class="eyebrow">Word choice</p><h2>“Fewer” and “less”</h2><p>Use <strong>fewer</strong> for countable items and <strong>less</strong> for amounts or uncountable quantities.</p><p class="example-line">Fewer pages, less time.</p></article>
    </section>
</div>
@endsection