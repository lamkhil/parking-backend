<?php

namespace App\Filament\Resources\ParkingGates\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ParkingGateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('type')
                    ->required(),
            ]);
    }
}
