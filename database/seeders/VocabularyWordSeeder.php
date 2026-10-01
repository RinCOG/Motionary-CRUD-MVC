<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\VocabularyWord;
use Illuminate\Database\Seeder;

class VocabularyWordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->firstOrCreate(
            ['email' => 'learner@motionary.test'],
            ['name' => 'Motionary Learner', 'password' => 'password']
        );

        $words = [
            ['serendipity', 'noun', '/ˌser.ənˈdɪp.ə.ti/', 'The occurrence of events by chance in a happy or beneficial way.', 'Finding that little book was pure serendipity.'],
            ['resilient', 'adjective', '/rɪˈzɪl.jənt/', 'Able to recover quickly from difficulties.', 'The resilient team learned from each setback.'],
            ['eloquent', 'adjective', '/ˈel.ə.kwənt/', 'Fluent or persuasive in speaking or writing.', 'Her eloquent explanation made the idea easy to grasp.'],
            ['meticulous', 'adjective', '/məˈtɪk.jə.ləs/', 'Showing great attention to detail.', 'He kept meticulous notes during the lecture.'],
            ['ephemeral', 'adjective', '/ɪˈfem.ər.əl/', 'Lasting for a very short time.', 'The sunset cast an ephemeral glow across the bay.'],
            ['curiosity', 'noun', '/ˌkjʊr.iˈɑː.sə.ti/', 'A strong desire to know or learn something.', 'Curiosity led Maya to look up the unfamiliar phrase.'],
            ['articulate', 'verb', '/ɑːrˈtɪk.jə.leɪt/', 'To express an idea clearly and effectively.', 'Try to articulate the main point in one sentence.'],
            ['nuance', 'noun', '/ˈnuː.ɑːns/', 'A subtle difference in meaning, expression, or feeling.', 'The synonym is close, but it misses the nuance.'],
            ['ponder', 'verb', '/ˈpɑːn.dər/', 'To think about something carefully.', 'She paused to ponder the question.'],
            ['vivid', 'adjective', '/ˈvɪv.ɪd/', 'Producing powerful feelings or clear images in the mind.', 'The author used vivid details to describe the scene.'],
            ['concise', 'adjective', '/kənˈsaɪs/', 'Giving a lot of information clearly in a few words.', 'A concise definition is easier to remember.'],
            ['inquisitive', 'adjective', '/ɪnˈkwɪz.ə.tɪv/', 'Eager to learn or know more.', 'The inquisitive student asked thoughtful follow-up questions.'],
        ];

        foreach ($words as [$term, $partOfSpeech, $phonetic, $definition, $example]) {
            VocabularyWord::query()->firstOrCreate(
                ['user_id' => $user->id, 'term' => $term],
                ['part_of_speech' => $partOfSpeech, 'phonetic' => $phonetic, 'definition' => $definition, 'example' => $example]
            );
        }
    }
}
