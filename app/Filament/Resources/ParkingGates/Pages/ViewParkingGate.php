<?php

namespace App\Filament\Resources\ParkingGates\Pages;

use App\Filament\Resources\ParkingGates\ParkingGateResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewParkingGate extends ViewRecord
{
    protected static string $resource = ParkingGateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
