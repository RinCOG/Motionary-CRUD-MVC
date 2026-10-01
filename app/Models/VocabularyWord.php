<?php

namespace App\Models;

use Database\Factories\VocabularyWordFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VocabularyWord extends Model
{
    /** @use HasFactory<VocabularyWordFactory> */
    use HasFactory;

    protected $fillable = ['user_id', 'term', 'part_of_speech', 'phonetic', 'definition', 'example'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
