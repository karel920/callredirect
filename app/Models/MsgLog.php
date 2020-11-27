<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsgLog extends Model
{
    use HasFactory;

    public function rDevice() {
        return $this->belongsTo(Device::class, 'device_id');
    }
}
