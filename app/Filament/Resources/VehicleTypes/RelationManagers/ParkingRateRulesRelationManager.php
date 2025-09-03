<?php

namespace App\Filament\Resources\VehicleTypes\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ParkingRateRulesRelationManager extends RelationManager
{
    protected static string $relationship = 'parkingRateRules';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('start_minute')
                    ->required()
                    ->numeric(),
                TextInput::make('end_minute')
                    ->numeric(),
                TextInput::make('fixed_price')
                    ->numeric(),
                TextInput::make('per_hour_price')
                    ->numeric(),
                TextInput::make('per_day_price')
                    ->numeric(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('start_minute')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('end_minute')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('fixed_price')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('per_hour_price')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('per_day_price')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
