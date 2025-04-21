<?php

namespace App\Filament\Resources\TempatKknResource\Pages;

use App\Filament\Resources\TempatKknResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTempatKkn extends EditRecord
{
    protected static string $resource = TempatKknResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
