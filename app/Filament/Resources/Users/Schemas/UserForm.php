<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\ParkingGate;
use App\Models\Shift;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required(),
                Select::make('parking_gate_id')
                    ->label('Parking Gate')
                    ->options(
                        ParkingGate::all()->pluck('name','id')
                    )
                    ->searchable(),
                Select::make('shift_id')
                    ->label('Shift')
                    ->options(
                        Shift::all()->pluck('name','id')
                    )
                    ->searchable(),
            ]);
    }
}
