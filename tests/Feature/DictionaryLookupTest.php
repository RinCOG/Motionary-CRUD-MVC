<?php

namespace Tests\Feature;

use App\Models\VocabularyWord;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DictionaryLookupTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_dictionary_entry_from_the_provider(): void
    {
        $entry = [['word' => 'serendipity', 'meanings' => []]];
        Http::fake(['api.dictionaryapi.dev/*' => Http::response($entry, 200)]);

        $this->getJson('/dictionary/serendipity')->assertOk()->assertExactJson($entry);
        Http::assertSent(fn (Request $request): bool => str_contains($request->url(), '/entries/en/serendipity'));
    }

    public function test_returns_not_found_when_the_provider_has_no_entry(): void
    {
        Http::fake(['api.dictionaryapi.dev/*' => Http::response(['title' => 'No Definitions Found'], 404)]);

        $this->getJson('/dictionary/notaword')->assertNotFound()->assertJsonPath('message', 'No dictionary entry was found for that word.');
    }

    public function test_rejects_dictionary_terms_with_url_syntax(): void
    {
        $this->getJson('/dictionary/<script>')->assertUnprocessable();
        Http::assertNothingSent();
    }

    public function test_returns_service_unavailable_when_the_provider_cannot_be_reached(): void
    {
        Http::fake(['api.dictionaryapi.dev/*' => Http::failedConnection()]);

        $this->getJson('/dictionary/serendipity')->assertServiceUnavailable();
    }

    public function test_uses_a_saved_lexical_entry_when_the_provider_is_unavailable(): void
    {
        VocabularyWord::factory()->create([
            'term' => 'serendipity',
            'part_of_speech' => 'noun',
            'definition' => 'A fortunate discovery.',
            'example' => 'The find was serendipity.',
        ]);
        Http::fake(['api.dictionaryapi.dev/*' => Http::failedConnection()]);

        $this->getJson('/dictionary/serendipity')
            ->assertOk()
            ->assertJsonPath('0.meanings.0.definitions.0.definition', 'A fortunate discovery.');
    }
}
