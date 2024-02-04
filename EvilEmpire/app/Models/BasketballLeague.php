<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BasketballLeague extends Model
{
    use HasFactory;

    public function t2name(): HasMany
    {
        return $this->hasMany(BasketballGame::class, 'league_id', 'id');
    }

    public function points(): HasMany
    {
        return $this->hasMany(BasketballPlayerGame::class, 'league_id', 'id');
    }
}
