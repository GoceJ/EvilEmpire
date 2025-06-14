<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FootballPoint extends Model
{
    use HasFactory;

    public function game(): HasOne
    {
        return $this->hasOne(FootballGame::class, 'points_id', 'id');
    }
}
