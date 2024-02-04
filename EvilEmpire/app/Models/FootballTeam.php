<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FootballTeam extends Model
{
    use HasFactory;

    public function gamet1(): HasMany
    {
        return $this->hasMany(FootballGame::class, 't1_id', 'id');
    }
    public function gamet2(): HasMany
    {
        return $this->hasMany(FootballGame::class, 't2_id', 'id');
    }

    public function gameHomeTeam(): HasMany
    {
        return $this->hasMany(FootballGame::class, 'home_team', 'id');
    }

}
