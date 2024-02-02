<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FootballGame extends Model
{
    use HasFactory;

    public function t1name(): BelongsTo
    {
        return $this->belongsTo(FootballTeam::class, 't1_id', 'id');
    }

    public function t2name(): BelongsTo
    {
        return $this->belongsTo(FootballTeam::class, 't2_id', 'id');
    }

    public function points(): HasOne
    {
        return $this->hasOne(FootballPoint::class, 'id', 'points_id');
    }

    public function league(): HasOne
    {
        return $this->hasOne(FootballLeague::class, 'id', 'league_id');
    }
}
