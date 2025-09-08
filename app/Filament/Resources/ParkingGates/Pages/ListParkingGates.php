<?php

namespace App\Filament\Resources\ParkingGates\Pages;

use App\Filament\Resources\ParkingGates\ParkingGateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListParkingGates extends ListRecords
{
    protected static string $resource = ParkingGateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
