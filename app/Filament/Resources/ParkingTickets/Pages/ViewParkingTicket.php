<?php

namespace App\Filament\Resources\ParkingTickets\Pages;

use App\Filament\Resources\ParkingTickets\ParkingTicketResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewParkingTicket extends ViewRecord
{
    protected static string $resource = ParkingTicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
