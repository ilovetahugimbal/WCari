<?php

namespace App\Filament\Resources\ToiletResource\Pages;

use App\Filament\Resources\ToiletResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListToilets extends ListRecords
{
    protected static string $resource = ToiletResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
