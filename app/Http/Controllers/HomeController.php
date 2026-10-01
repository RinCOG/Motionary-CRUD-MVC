<?php

namespace App\Http\Controllers;

use App\Models\VocabularyWord;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home');
    }

    public function dashboard(): View
    {
        $user = request()->user();
        $words = $user->vocabularyWords()->latest()->limit(8)->get();

        return view('dashboard', [
            'words' => $words,
            'wordCount' => $user->vocabularyWords()->count(),
            'recentWord' => VocabularyWord::query()->whereBelongsTo($user)->latest()->value('term'),
        ]);
    }
}
