<?php

namespace App\Filament\Resources\ChildResource\Pages;

use App\Filament\Resources\ChildResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewChild extends ViewRecord
{
    protected static string $resource = ChildResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
            Actions\Action::make('back')
                ->label('Kembali')
                ->url(fn () => ChildResource::getUrl('index')),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            // Tambahkan widget tambahan jika diperlukan
        ];
    }
}