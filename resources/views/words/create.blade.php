@extends('layouts.app')

@section('title', 'Add a word')

@section('content')
<div class="app-container">
    <header class="page-heading"><div><p class="eyebrow">Wordbook / New entry</p><h1>Add a word</h1><p class="page-subtitle">Keep a definition, pronunciation, and example for future review.</p></div><a href="{{ route('words.index') }}" class="btn btn-outline-dark px-3 py-2"><i class="fas fa-arrow-left me-2" aria-hidden="true"></i>Back to wordbook</a></header>
    <section class="surface"><div class="surface-heading"><h2>Vocabulary entry</h2></div><div class="surface-body"><form action="{{ route('words.store') }}" method="POST">@csrf @include('words._fields')<div class="d-flex justify-content-end gap-2 mt-4"><a href="{{ route('words.index') }}" class="btn btn-outline-dark">Cancel</a><button class="btn btn-primary px-4" type="submit">Save word</button></div></form></div></section>
</div>
@endsection