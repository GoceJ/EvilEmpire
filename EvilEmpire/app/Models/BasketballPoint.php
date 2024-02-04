<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BasketballPoint extends Model
{
    use HasFactory;

    public function t2name(): HasOne
    {
        return $this->hasOne(BasketballGame::class, 'points_id', 'id');
    }
}
