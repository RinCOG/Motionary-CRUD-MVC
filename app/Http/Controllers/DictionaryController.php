<?php

namespace App\Http\Controllers;

use App\Models\VocabularyWord;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class DictionaryController extends Controller
{
    public function show(string $word): JsonResponse
    {
        $word = trim($word);

        if (mb_strlen($word) > 80 || preg_match('/^[\p{L}\p{M}\'-]+$/u', $word) !== 1) {
            return response()->json(['message' => 'Search for one word using letters, apostrophes, or hyphens.'], 422);
        }

        try {
            $response = Http::acceptJson()
                ->timeout(8)
                ->get('https://api.dictionaryapi.dev/api/v2/entries/en/'.rawurlencode($word));
        } catch (ConnectionException) {
            return $this->localEntry($word)
                ?? response()->json(['message' => 'Dictionary service is temporarily unavailable.'], 503);
        }

        if ($response->status() === 404) {
            return $this->localEntry($word)
                ?? response()->json(['message' => 'No dictionary entry was found for that word.'], 404);
        }

        if (! $response->successful() || ! is_array($response->json())) {
            return $this->localEntry($word)
                ?? response()->json(['message' => 'Dictionary service is temporarily unavailable.'], 503);
        }

        return response()->json($response->json());
    }

    private function localEntry(string $term): ?JsonResponse
    {
        $word = VocabularyWord::query()
            ->whereRaw('LOWER(term) = ?', [mb_strtolower($term)])
            ->first();

        if ($word === null) {
            return null;
        }

        return response()->json([[
            'word' => $word->term,
            'phonetic' => $word->phonetic,
            'meanings' => [[
                'partOfSpeech' => $word->part_of_speech,
                'definitions' => [[
                    'definition' => $word->definition,
                    'example' => $word->example,
                    'synonyms' => [],
                ]],
            ]],
        ]]);
    }
}
