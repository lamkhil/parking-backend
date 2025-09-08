<?php

namespace App\Filament\Resources\ParkingTickets\Pages;

use App\Filament\Resources\ParkingTickets\ParkingTicketResource;
use Filament\Resources\Pages\CreateRecord;

class CreateParkingTicket extends CreateRecord
{
    protected static string $resource = ParkingTicketResource::class;
}
