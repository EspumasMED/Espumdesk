<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Imports\UserImport;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Collection;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
                ->processCollectionUsing(function (string $modelClass, Collection $collection) {
                    $importer = new UserImport();
                    $importer->collection($collection);
                    return $collection;
                })
                ->use(UserImport::class),
            Actions\CreateAction::make(),
        ];
    }
}
