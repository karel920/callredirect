<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceLocation extends Model
{
    use HasFactory;

    public function rDevice() {
        return $this->belongsTo(Device::class, 'device_id');
    }
}
