<?php

namespace App\Filament\Resources\ParkingTickets\Pages;

use App\Filament\Resources\ParkingTickets\ParkingTicketResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditParkingTicket extends EditRecord
{
    protected static string $resource = ParkingTicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
