@extends('layouts.app')

@section('title', $word->term)

@section('content')
<div class="app-container">
    <header class="page-heading"><div><p class="eyebrow">My wordbook / Saved entry</p><h1>{{ $word->term }}</h1><p class="page-subtitle">{{ $word->part_of_speech }} <span class="phonetic-text">{{ $word->phonetic }}</span></p></div><div class="d-flex gap-2"><a href="{{ route('words.index') }}" class="btn btn-outline-dark px-3 py-2">Wordbook</a><a href="{{ route('words.edit', $word) }}" class="btn btn-primary px-3 py-2"><i class="fas fa-pen me-2" aria-hidden="true"></i>Edit</a></div></header>
    <section class="surface"><div class="surface-heading"><h2>Definition</h2><button type="button" class="action-icon" data-speak-word="{{ $word->term }}" title="Play word pronunciation" aria-label="Play word pronunciation"><i class="fas fa-volume-high" aria-hidden="true"></i></button></div><div class="surface-body"><p class="definition-text">{{ $word->definition }}</p>@if($word->example)<p class="definition-example mt-3">“{{ $word->example }}”</p>@endif</div></section>
    <form action="{{ route('words.destroy', $word) }}" method="POST" class="mt-3" onsubmit="return confirm('Remove this word from your wordbook?')">@csrf @method('DELETE')<button class="btn btn-outline-danger" type="submit"><i class="fas fa-trash me-2" aria-hidden="true"></i>Remove from wordbook</button></form>
</div>
@endsection