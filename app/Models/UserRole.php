<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;


    public function rTeam() {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function rUsers() {
        return $this->hasMany(User::class, 'role_id');
    }
}
