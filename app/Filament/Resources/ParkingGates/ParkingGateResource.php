<?php

namespace App\Filament\Resources\ParkingGates;

use App\Filament\Resources\ParkingGates\Pages\CreateParkingGate;
use App\Filament\Resources\ParkingGates\Pages\EditParkingGate;
use App\Filament\Resources\ParkingGates\Pages\ListParkingGates;
use App\Filament\Resources\ParkingGates\Pages\ViewParkingGate;
use App\Filament\Resources\ParkingGates\Schemas\ParkingGateForm;
use App\Filament\Resources\ParkingGates\Schemas\ParkingGateInfolist;
use App\Filament\Resources\ParkingGates\Tables\ParkingGatesTable;
use App\Models\ParkingGate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ParkingGateResource extends Resource
{
    protected static ?string $model = ParkingGate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ParkingGateForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ParkingGateInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ParkingGatesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListParkingGates::route('/'),
            'create' => CreateParkingGate::route('/create'),
            'view' => ViewParkingGate::route('/{record}'),
            'edit' => EditParkingGate::route('/{record}/edit'),
        ];
    }
}
