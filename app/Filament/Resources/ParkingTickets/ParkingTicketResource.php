<?php

namespace App\Filament\Resources\ParkingTickets;

use App\Filament\Resources\ParkingTickets\Pages\CreateParkingTicket;
use App\Filament\Resources\ParkingTickets\Pages\EditParkingTicket;
use App\Filament\Resources\ParkingTickets\Pages\ListParkingTickets;
use App\Filament\Resources\ParkingTickets\Pages\ViewParkingTicket;
use App\Filament\Resources\ParkingTickets\Schemas\ParkingTicketForm;
use App\Filament\Resources\ParkingTickets\Schemas\ParkingTicketInfolist;
use App\Filament\Resources\ParkingTickets\Tables\ParkingTicketsTable;
use App\Models\ParkingTicket;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ParkingTicketResource extends Resource
{
    protected static ?string $model = ParkingTicket::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'ticket_number';

    public static function form(Schema $schema): Schema
    {
        return ParkingTicketForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ParkingTicketInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ParkingTicketsTable::configure($table);
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
            'index' => ListParkingTickets::route('/'),
            'create' => CreateParkingTicket::route('/create'),
            'view' => ViewParkingTicket::route('/{record}'),
            'edit' => EditParkingTicket::route('/{record}/edit'),
        ];
    }
}
