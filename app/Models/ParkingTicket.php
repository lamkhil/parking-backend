<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingTicket extends Model
{
    public function parkingGateIn()
    {
        return $this->belongsTo(ParkingGate::class, 'gate_in_id');
    }

    public function parkingGateOut()
    {
        return $this->belongsTo(ParkingGate::class, 'gate_out_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
    }
}
