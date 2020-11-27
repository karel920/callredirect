<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForceIncomeList extends Model
{
    use HasFactory;

    public function rForceIncome() {
        return $this->belongsTo(ForceIncomeList::class, 'income_id');
    }
}
