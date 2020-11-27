<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForceIncome extends Model
{
    use HasFactory;

    public function rTeam() {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function rForceIncomeLists() {
        return $this->hasMany(ForceIncomeList::class, 'income_id');
    }
}