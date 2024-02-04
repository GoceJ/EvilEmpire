<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BasketballTeam extends Model
{
    use HasFactory;

    public function basketballGamesT1(): HasMany
    {
        return $this->hasMany(BasketballGame::class, 't1_id', 'id');
    }
    public function basketballGamesT2(): HasMany
    {
        return $this->hasMany(BasketballGame::class, 't2_id', 'id');
    }

    public function basketballGamesHomeTeam(): HasMany
    {
        return $this->hasMany(BasketballGame::class, 'home_team', 'id');
    }

    public function basketballPlayerGames(): HasMany
    {
        return $this->hasMany(BasketballPlayerGame::class);
    }
}
