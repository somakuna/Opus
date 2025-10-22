<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, Prunable, SoftDeletes;
    protected $guarded = [];
    protected $casts = [
        'date_lended' => 'date',
        'date_returned' => 'date',
    ];
}
