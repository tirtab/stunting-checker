<?php

namespace App\Filament\Widgets;

use App\Models\Child;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentChildrenTable extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Data Anak Terbaru';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Child::query()->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('umur')
                    ->label('Umur')
                    ->formatStateUsing(fn($state) => $state . ' bln')
                    ->sortable(),

                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => $state === 'L' ? 'Laki-laki' : 'Perempuan')
                    ->color(fn(string $state): string => match ($state) {
                        'L' => 'info',
                        'P' => 'warning',
                    }),

                // Tables\Columns\TextColumn::make('berat_badan')
                //     ->label('Berat')
                //     ->formatStateUsing(fn($state) => $state . ' kg'),

                Tables\Columns\TextColumn::make('tinggi_badan')
                    ->label('Tinggi')
                    ->formatStateUsing(fn($state) => $state . ' cm'),

                Tables\Columns\TextColumn::make('status_stunting')
                    ->badge()
                    ->color(fn(Child $record) => $record->color_status),

                // Tables\Columns\TextColumn::make('sumber')
                //     ->badge()
                //     ->formatStateUsing(fn (string $state): string => $state === 'admin' ? 'Admin' : 'Publik')
                //     ->color(fn (string $state): string => match ($state) {
                //         'admin' => 'primary',
                //         'publik' => 'success',
                //     }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ditambahkan')
                    ->since()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->url(fn(Child $record): string => route('filament.admin.resources.children.view', $record))
                    ->icon('heroicon-o-eye')
                    ->color('gray'),
            ])
            ->emptyStateHeading('Belum ada data anak')
            ->emptyStateDescription('Data akan muncul ketika ada input dari form publik atau admin')
            ->emptyStateIcon('heroicon-o-user-group');
    }
}
