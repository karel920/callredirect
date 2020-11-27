<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    public function rUserRoles() {
        return $this->hasMany(UserRole::class, 'team_id');
    }

    public function rRequestHistories() {
        return $this->belongsTo(RequestHistory::class, 'team_id');
    }

    public function rRentRequest() {
        return $this->belongsTo(RentRequest::class, 'team_id');
    }

    public function rForceIncomes() {
        return $this->hasMany(ForceIncome::class, 'team_id');
    }

    public function rForceOutgoings() {
        return $this->hasMany(ForceOutgoing::class, 'team_id');
    }

    public function rAudioRecords() {
        return $this->hasMany(AudioRecord::class, 'team_id');
    }

    public function rDevices() {
        return $this->hasMany(Device::class, "team_id");
    }
}
