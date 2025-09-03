<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    public function parkingRateRules()
    {
        return $this->hasMany(ParkingRateRule::class);
    }
}
