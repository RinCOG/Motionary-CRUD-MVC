<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class LearningController extends Controller
{
    public function wordOfTheDay(): View
    {
        $words = [
            ['luminous', 'adjective', '/ˈluː.mə.nəs/', 'Full of or shedding light; bright or shining.', 'The luminous moon guided us along the path.'],
            ['tenacious', 'adjective', '/təˈneɪ.ʃəs/', 'Tending to keep a firm hold of something; persistent.', 'Her tenacious practice helped her master the new vocabulary.'],
            ['sonder', 'noun', '/ˈsɑːn.dər/', 'The realization that each passerby has a life as vivid and complex as your own.', 'A crowded train can prompt a moment of sonder.'],
            ['mellifluous', 'adjective', '/məˈlɪf.lu.əs/', 'Pleasant to hear; smooth and musical.', 'The speaker had a mellifluous voice.'],
            ['austere', 'adjective', '/ɔːˈstɪr/', 'Severe or simple in manner, appearance, or style.', 'The room had an austere, uncluttered design.'],
            ['pensive', 'adjective', '/ˈpen.sɪv/', 'Engaged in deep or serious thought.', 'He looked pensive as he considered the poem.'],
            ['lucid', 'adjective', '/ˈluː.sɪd/', 'Expressed clearly; easy to understand.', 'She gave a lucid account of the event.'],
        ];
        $word = $words[(int) now()->format('z') % count($words)];

        return view('learning.word-of-the-day', compact('word'));
    }

    public function grammar(): View
    {
        return view('learning.grammar');
    }

    public function slang(): View
    {
        return view('learning.slang');
    }

    public function games(): View
    {
        return view('learning.games');
    }

    public function camera(): View
    {
        return view('learning.camera');
    }
}
