<?php

namespace App\Filament\Resources\PendaftaranKknResource\Pages;

use App\Filament\Resources\PendaftaranKknResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPendaftaranKkns extends ListRecords
{
    protected static string $resource = PendaftaranKknResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
