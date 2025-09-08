<?php

namespace App\Filament\Resources\ParkingTickets\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ParkingTicketInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('gate_in_id')
                    ->numeric(),
                TextEntry::make('gate_out_id')
                    ->numeric(),
                TextEntry::make('ticket_number'),
                TextEntry::make('issued_at')
                    ->dateTime(),
                TextEntry::make('expires_at')
                    ->dateTime(),
                TextEntry::make('exited_at')
                    ->dateTime(),
                TextEntry::make('duration_minutes')
                    ->numeric(),
                TextEntry::make('vehicle_plate_number'),
                TextEntry::make('status'),
                TextEntry::make('amount')
                    ->numeric(),
                TextEntry::make('currency'),
                TextEntry::make('payment_method'),
                TextEntry::make('transaction_id'),
                TextEntry::make('external_reference'),
                TextEntry::make('paid_at')
                    ->dateTime(),
                TextEntry::make('paid_by'),
                TextEntry::make('issued_by'),
                TextEntry::make('cancelled_at')
                    ->dateTime(),
                TextEntry::make('cancelled_by'),
                TextEntry::make('name'),
                TextEntry::make('description'),
                TextEntry::make('notes'),
                TextEntry::make('slug'),
                TextEntry::make('status_message'),
                TextEntry::make('status_code'),
                TextEntry::make('created_by'),
                TextEntry::make('updated_by'),
                TextEntry::make('deleted_by'),
                TextEntry::make('ip_address'),
                TextEntry::make('user_agent'),
                TextEntry::make('photo_in'),
                TextEntry::make('photo_out'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
                TextEntry::make('deleted_at')
                    ->dateTime(),
            ]);
    }
}
