<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class VehicleType extends Model
{

    protected $appends = [
        'image_url'
    ];
    
    public function parkingRateRules()
    {
        return $this->hasMany(ParkingRateRule::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image == null) {
            return null;
        }

        return Storage::url($this->image);
    }
}
