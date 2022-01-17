<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Difficulty extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
    ];

    protected $with = [
        'weeks'
    ];

    public function weeks()
    {
       return $this->hasMany(Week::class);
    }


}
