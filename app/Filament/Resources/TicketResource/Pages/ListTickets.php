<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTickets extends ListRecords
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // Si necesitas personalizar la tabla, puedes usar este método:
    // protected function table(Table $table): Table
    // {
    //     return $table
    //         ->columns([
    //             // Define tus columnas aquí
    //         ])
    //         ->filters([
    //             // Define tus filtros aquí
    //         ])
    //         ->actions([
    //             // Define tus acciones aquí
    //         ])
    //         ->bulkActions([
    //             // Define tus acciones en masa aquí
    //         ]);
    // }
}