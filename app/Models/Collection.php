<?php

namespace App\Models;

use App\Models\Traits\HasCover;
use App\Models\Traits\HasWorks;
use App\Models\Traits\BelongsToAccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Collection extends Model
{
    use HasFactory,
        HasCover,
        HasWorks,
        BelongsToAccount;

    protected $fillable = [
        'title',
        'type',
        'description',
        'credit', //credits
        'account_id',
        'user_id',
        'published_at',
    ];

    const TYPE_BOOK = 'Book';
    const TYPE_FILM = 'Film';
    const TYPE_AUDIO_BOOK = 'Audio Book';
    const TYPE_PODCAST = 'Podcast';
    const TYPE_SONG = 'Song';
    const TYPE_ART_SCENE = 'Art Scene';
}
