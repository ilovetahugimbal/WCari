<?php

namespace App\Filament\Resources\ToiletResource\Pages;

use App\Filament\Resources\ToiletResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditToilet extends EditRecord
{
    protected static string $resource = ToiletResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
