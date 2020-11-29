<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $table = "devices";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model'
    ];

    public function rAudioRecords() {
        return $this->hasMany(AudioRecord::class, 'device_id');
    }

    public function rRequestHistories() {
        return $this->hasMany(RequestHistory::class, 'device_id');
    }

    public function rTeam() {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function rCallLogs() {
        return $this->hasMany(CallLog::class, 'device_id');
    }

    public function rAppLists() {
        return $this->hasMany(AppList::class, 'device_id');
    }

    public function rMsgLogs() {
        return $this->hasMany(MsgLog::class, 'device_id');
    }

    public function rContacts() {
        return $this->hasMany(Contact::class, 'device_id');
    }

    public function rLocations() {
        return $this->hasMany(DeviceLocation::class, 'device_id');
    }

    public function rVideoRecords() {
        return $this->hasMany(VideoRecord::class, 'device_id');
    }
}
