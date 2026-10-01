<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VocabularyWord;
use Database\Seeders\VocabularyWordSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_their_wordbook(): void
    {
        $user = User::factory()->create();
        VocabularyWord::factory()->for($user)->create(['term' => 'serendipity']);

        $response = $this->actingAs($user)->get('/words');

        $response->assertSeeText('My wordbook');
        $response->assertSeeText('serendipity');
    }

    public function test_guest_is_redirected_from_the_wordbook(): void
    {
        $this->get('/words')->assertRedirect('/login');
    }

    public function test_dictionary_and_learning_modules_are_public(): void
    {
        $this->get('/')->assertSeeText('Dictionary search');
        $this->get('/word-of-the-day')->assertSeeText('Word of the day');
        $this->get('/grammar')->assertSeeText('Grammar notes');
        $this->get('/slang')->assertSeeText('Slang desk');
        $this->get('/games')->assertSeeText('Five-letter word');
    }

    public function test_authenticated_user_can_save_a_dictionary_entry(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/words', [
            'term' => 'luminous',
            'part_of_speech' => 'adjective',
            'phonetic' => '/ˈluː.mə.nəs/',
            'definition' => 'Full of or shedding light.',
            'example' => 'A luminous moon.',
        ]);

        $response->assertCreated()->assertJsonPath('word.term', 'luminous');
        $this->assertDatabaseHas('vocabulary_words', ['user_id' => $user->id, 'term' => 'luminous']);
    }

    public function test_authenticated_user_can_update_and_remove_a_saved_word(): void
    {
        $user = User::factory()->create();
        $word = VocabularyWord::factory()->for($user)->create(['term' => 'lucid']);

        $this->actingAs($user)->put(route('words.update', $word), [
            'term' => 'lucid',
            'part_of_speech' => 'adjective',
            'phonetic' => '/ˈluː.sɪd/',
            'definition' => 'Clear and easy to understand.',
            'example' => 'She gave a lucid explanation.',
        ])->assertRedirect(route('words.show', $word));

        $this->assertDatabaseHas('vocabulary_words', ['id' => $word->id, 'definition' => 'Clear and easy to understand.']);

        $this->delete(route('words.destroy', $word))->assertRedirect(route('words.index'));
        $this->assertDatabaseMissing('vocabulary_words', ['id' => $word->id]);
    }

    public function test_user_cannot_view_another_users_saved_word(): void
    {
        $owner = User::factory()->create();
        $visitor = User::factory()->create();
        $word = VocabularyWord::factory()->for($owner)->create();

        $this->actingAs($visitor)->get(route('words.show', $word))->assertNotFound();
    }

    public function test_vocabulary_word_seeder_creates_twelve_sample_entries(): void
    {
        $this->seed(VocabularyWordSeeder::class);

        $this->assertDatabaseCount('vocabulary_words', 12);
    }

    public function test_dictionary_search_filters_saved_words(): void
    {
        $user = User::factory()->create();
        VocabularyWord::factory()->for($user)->create(['term' => 'serendipity']);
        VocabularyWord::factory()->for($user)->create(['term' => 'meticulous']);

        $this->actingAs($user)->get('/words?q=seren')
            ->assertSeeText('serendipity')
            ->assertDontSeeText('meticulous');
    }

    public function test_camera_lab_is_available_without_authentication(): void
    {
        $this->get('/camera')->assertSeeText('No gesture is detected or sent to a server.');
    }
}
