<?php

namespace App\Filament\Resources\ParkingGates\Pages;

use App\Filament\Resources\ParkingGates\ParkingGateResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditParkingGate extends EditRecord
{
    protected static string $resource = ParkingGateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
