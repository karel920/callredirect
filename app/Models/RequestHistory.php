<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestHistory extends Model
{
    use HasFactory;

    public function rTeam() {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function rDevice() {
        return $this->belongsTo(Device::class, 'device_id');
    }
}
