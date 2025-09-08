<?php

namespace App\Filament\Resources\ParkingTickets\Pages;

use App\Filament\Resources\ParkingTickets\ParkingTicketResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListParkingTickets extends ListRecords
{
    protected static string $resource = ParkingTicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
