@extends('layouts.app')

@section('title', 'Edit ' . $word->term)

@section('content')
<div class="app-container">
    <header class="page-heading"><div><p class="eyebrow">Wordbook / Edit entry</p><h1>Edit “{{ $word->term }}”</h1></div><a href="{{ route('words.show', $word) }}" class="btn btn-outline-dark px-3 py-2"><i class="fas fa-arrow-left me-2" aria-hidden="true"></i>Back to entry</a></header>
    <section class="surface"><div class="surface-heading"><h2>Vocabulary entry</h2></div><div class="surface-body"><form action="{{ route('words.update', $word) }}" method="POST">@csrf @method('PUT') @include('words._fields')<div class="d-flex justify-content-end gap-2 mt-4"><a href="{{ route('words.show', $word) }}" class="btn btn-outline-dark">Cancel</a><button class="btn btn-primary px-4" type="submit">Save changes</button></div></form></div></section>
</div>
@endsection