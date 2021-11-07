<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingPeriod extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'start'=>'datetime',
        'end'=>'datetime',
    ];
}
