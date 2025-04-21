<?php

namespace App\Filament\Resources\TempatKknResource\Pages;

use App\Filament\Resources\TempatKknResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTempatKkns extends ListRecords
{
    protected static string $resource = TempatKknResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
