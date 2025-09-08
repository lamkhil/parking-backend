<?php

namespace App\Filament\Resources\ParkingTickets\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ParkingTicketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('gate_in_id')
                    ->required()
                    ->numeric(),
                TextInput::make('gate_out_id')
                    ->numeric(),
                TextInput::make('ticket_number')
                    ->required(),
                DateTimePicker::make('issued_at')
                    ->required(),
                DateTimePicker::make('expires_at')
                    ->required(),
                DateTimePicker::make('exited_at'),
                TextInput::make('duration_minutes')
                    ->numeric(),
                TextInput::make('vehicle_plate_number')
                    ->required(),
                TextInput::make('status')
                    ->required()
                    ->default('active'),
                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('currency')
                    ->required()
                    ->default('IDR'),
                TextInput::make('payment_method')
                    ->required()
                    ->default('cash'),
                TextInput::make('transaction_id'),
                TextInput::make('external_reference'),
                DateTimePicker::make('paid_at'),
                TextInput::make('paid_by'),
                TextInput::make('issued_by'),
                DateTimePicker::make('cancelled_at'),
                TextInput::make('cancelled_by'),
                TextInput::make('name'),
                TextInput::make('description'),
                TextInput::make('notes'),
                TextInput::make('slug'),
                TextInput::make('status_message'),
                TextInput::make('status_code'),
                Textarea::make('metadata')
                    ->columnSpanFull(),
                TextInput::make('created_by'),
                TextInput::make('updated_by'),
                TextInput::make('deleted_by'),
                TextInput::make('ip_address'),
                TextInput::make('user_agent'),
                TextInput::make('photo_in'),
                TextInput::make('photo_out'),
            ]);
    }
}
