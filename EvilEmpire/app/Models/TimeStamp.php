<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeStamp extends Model
{
    use HasFactory;

    public $fillable = ['time_stamp', 'basket_import', 'player_import', 'football_import', 'basket_error', 'player_error', 'football_error'];

}
