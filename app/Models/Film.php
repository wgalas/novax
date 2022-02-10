<?php

namespace App\Models;

use App\Models\Traits\HasCover;
use Cartalyst\Tags\TaggableTrait;
use App\Models\Traits\HasLargeFile;
use Cartalyst\Tags\TaggableInterface;
use App\Models\Traits\BelongsToAccount;
use App\Models\Traits\BelongsToClass;
use App\Models\Traits\HasFreeArtScenes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//TODO: upload film, published_button,
class Film extends Model implements TaggableInterface
{
    use HasFactory,
        HasCover,
        HasFreeArtScenes,
        BelongsToAccount,
        BelongsToClass,
        HasLargeFile,
        TaggableTrait;

    protected $fillable = [
        'title',
        'type', // film | trailer | animation
        'genre_id',
        'age_restriction',
        'language_id',
        'user_id',
        'account_id',
        'cost_type',
        'cost',
        'published_at',
        'credit',
        'description',
    ];

    const TYPE_FILM = 'Film';
    const TYPE_TRAILER = 'Trailer';
    const TYPE_ANIMATION = 'Animation';

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}
