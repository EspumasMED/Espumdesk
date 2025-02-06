<?php

namespace App\Filament\Resources\EquipmentResource\Pages;

use App\Filament\Resources\EquipmentResource;
use App\Imports\EquipmentImport;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Collection;

class ListEquipment extends ListRecords
{
    protected static string $resource = EquipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
                ->processCollectionUsing(function (string $modelClass, Collection $collection) {
                    $importer = new EquipmentImport();
                    $importer->collection($collection);
                    return $collection;
                })
                ->use(EquipmentImport::class),
            Actions\CreateAction::make()
                ->modalWidth('4xl'),
        ];
    }
}
