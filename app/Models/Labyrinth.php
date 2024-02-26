<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Labyrinth extends Model
{
    use HasFactory;

    protected $casts = [
        'playfield' => 'json',
        'start_coordinates' => 'json',
        'end_coordinates' => 'json'
    ];

    protected $guarded = ['id'];
}
