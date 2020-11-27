<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentRequest extends Model
{
    use HasFactory;

    public function rTeam() {
        return $this->hasOne(Team::class, 'team_id');
    }
}
