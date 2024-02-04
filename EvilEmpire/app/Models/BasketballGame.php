<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BasketballGame extends Model
{
    use HasFactory;

    public function t1name(): BelongsTo
    {
        return $this->belongsTo(BasketballTeam::class, 'id', 't1_id');
    }

    public function t2name(): BelongsTo
    {
        return $this->belongsTo(BasketballTeam::class, 'id', 't2_id');
    }

    public function points(): HasOne
    {
        return $this->hasOne(BasketballPoint::class, 'id', 'points_id');
    }

    public function league(): HasOne
    {
        return $this->hasOne(BasketballLeague::class);
    }
}
