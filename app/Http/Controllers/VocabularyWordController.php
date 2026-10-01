<?php

namespace App\Http\Controllers;

use App\Models\VocabularyWord;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VocabularyWordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = trim($request->string('q')->toString());
        $words = $request->user()->vocabularyWords()
            ->when($search !== '', fn ($query) => $query->where('term', 'like', "%{$search}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('words.index', compact('words', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('words.create', ['word' => new VocabularyWord]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'term' => ['required', 'string', 'max:120'],
            'part_of_speech' => ['nullable', 'string', 'max:40'],
            'phonetic' => ['nullable', 'string', 'max:160'],
            'definition' => ['required', 'string', 'max:5000'],
            'example' => ['nullable', 'string', 'max:5000'],
        ]);

        $word = $request->user()->vocabularyWords()->updateOrCreate(['term' => $validated['term']], $validated);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Saved to your wordbook.', 'word' => $word], 201);
        }

        return redirect()->route('words.index')->with('success', 'Word saved to your wordbook.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, VocabularyWord $word): View
    {
        abort_unless($word->user_id === $request->user()->id, 404);

        return view('words.show', compact('word'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, VocabularyWord $word): View
    {
        abort_unless($word->user_id === $request->user()->id, 404);

        return view('words.edit', compact('word'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VocabularyWord $word): RedirectResponse
    {
        abort_unless($word->user_id === $request->user()->id, 404);

        $validated = $request->validate([
            'term' => ['required', 'string', 'max:120'],
            'part_of_speech' => ['nullable', 'string', 'max:40'],
            'phonetic' => ['nullable', 'string', 'max:160'],
            'definition' => ['required', 'string', 'max:5000'],
            'example' => ['nullable', 'string', 'max:5000'],
        ]);
        $word->update($validated);

        return redirect()->route('words.show', $word)->with('success', 'Word updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, VocabularyWord $word): RedirectResponse
    {
        abort_unless($word->user_id === $request->user()->id, 404);
        $word->delete();

        return redirect()->route('words.index')->with('success', 'Word removed from your wordbook.');
    }
}
