<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChildResource\Pages;
use App\Filament\Resources\ChildResource\RelationManagers;
use App\Models\Child;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Support\Carbon;

class ChildResource extends Resource
{
    protected static ?string $model = Child::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Data Stunting';

    protected static ?string $navigationLabel = 'Data Anak';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Identitas Anak')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Nama lengkap anak'),
                        Forms\Components\Select::make('jenis_kelamin')
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                            ])
                            ->required()
                            ->native(false),
                        Forms\Components\TextInput::make('umur')
                            ->label('Umur (bulan)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(60)
                            ->required()
                            ->placeholder('Umur dalam bulan (0-60)'),
                        Forms\Components\DatePicker::make('tanggal_ukur')
                            ->required()
                            ->default(now())
                            ->maxDate(now()),
                    ])->columns(2),

                Forms\Components\Section::make('Data Pengukuran')
                    ->schema([
                        Forms\Components\TextInput::make('tinggi_badan')
                            ->label('Tinggi Badan (cm)')
                            ->numeric()
                            ->step(0.01)
                            ->minValue(30)
                            ->maxValue(150)
                            ->required()
                            ->suffix('cm'),
                    ])->columns(3),

                Forms\Components\Section::make('Informasi Tambahan')
                    ->schema([
                        Forms\Components\Textarea::make('catatan')
                            ->maxLength(65535)
                            ->placeholder('Catatan tambahan...')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => $state === 'L' ? 'Laki-laki' : 'Perempuan')
                    ->color(fn(string $state): string => match ($state) {
                        'L' => 'info',
                        'P' => 'warning',
                    }),
                Tables\Columns\TextColumn::make('umur')
                    ->label('Umur')
                    ->formatStateUsing(fn($state) => "{$state} bln")
                    ->sortable(),
                Tables\Columns\TextColumn::make('berat_badan')
                    ->label('Berat')
                    ->formatStateUsing(fn($state) => "{$state} kg")
                    ->sortable(),
                Tables\Columns\TextColumn::make('tinggi_badan')
                    ->label('Tinggi')
                    ->formatStateUsing(fn($state) => "{$state} cm")
                    ->sortable(),
                Tables\Columns\TextColumn::make('lingkar_lengan')
                    ->label('Lingkar Lengan')
                    ->formatStateUsing(fn($state) => "{$state} cm")
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_stunting')
                    ->badge()
                    ->color(fn(Child $record) => $record->color_status),
                // Tables\Columns\TextColumn::make('sumber')
                //     ->badge()
                //     ->formatStateUsing(fn(string $state): string => $state === 'admin' ? 'Admin' : 'Publik')
                //     ->color(fn(string $state): string => match ($state) {
                //         'admin' => 'primary',
                //         'publik' => 'success',
                //     }),
                Tables\Columns\TextColumn::make('tanggal_ukur')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ditambahkan')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis_kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ]),
                Tables\Filters\SelectFilter::make('status_stunting')
                    ->options([
                        'Normal' => 'Normal',
                        'Stunting' => 'Stunting',
                        'Stunting Berat' => 'Stunting Berat',
                    ]),
                // Tables\Filters\SelectFilter::make('sumber')
                //     ->options([
                //         'admin' => 'Admin',
                //         'publik' => 'Publik',
                //     ]),
                Tables\Filters\Filter::make('tanggal_ukur')
                    ->form([
                        Forms\Components\DatePicker::make('dari_tanggal'),
                        Forms\Components\DatePicker::make('sampai_tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['dari_tanggal'],
                                fn($query, $date) => $query->whereDate('tanggal_ukur', '>=', $date)
                            )
                            ->when(
                                $data['sampai_tanggal'],
                                fn($query, $date) => $query->whereDate('tanggal_ukur', '<=', $date)
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada data anak')
            ->emptyStateDescription('Data akan muncul ketika ada input dari form publik atau admin')
            ->emptyStateIcon('heroicon-o-user-group')
            ->emptyStateActions([
                Tables\Actions\Action::make('create')
                    ->label('Tambah Data Anak')
                    ->url(route('filament.admin.resources.children.create'))
                    ->icon('heroicon-o-plus'),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Data Identitas Anak')
                    ->schema([
                        Infolists\Components\TextEntry::make('nama'),
                        Infolists\Components\TextEntry::make('jenis_kelamin')
                            ->formatStateUsing(fn(string $state): string => $state === 'L' ? 'Laki-laki' : 'Perempuan'),
                        Infolists\Components\TextEntry::make('umur')
                            ->suffix(' bulan'),
                        Infolists\Components\TextEntry::make('tanggal_ukur')
                            ->date('d/m/Y'),
                        // Infolists\Components\TextEntry::make('sumber')
                        //     ->formatStateUsing(fn(string $state): string => $state === 'admin' ? 'Admin' : 'Publik')
                        //     ->badge()
                        //     ->color(fn(string $state): string => match ($state) {
                        //         'admin' => 'primary',
                        //         'publik' => 'success',
                        //     }),
                    ])->columns(3),

                Infolists\Components\Section::make('Hasil Pengukuran')
                    ->schema([

                        Infolists\Components\TextEntry::make('tinggi_badan')
                            ->suffix(' cm'),

                        Infolists\Components\TextEntry::make('status_stunting')
                            ->badge()
                            ->color(fn(Child $record) => $record->color_status),
                    ])->columns(2),

                Infolists\Components\Section::make('Informasi Sistem')
                    ->schema([
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Ditambahkan')
                            ->since(),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Terakhir diupdate')
                            ->since(),
                    ])->columns(2),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChildren::route('/'),
            'create' => Pages\CreateChild::route('/create'),
            'edit' => Pages\EditChild::route('/{record}/edit'),
            'view' => Pages\ViewChild::route('/{record}'),
        ];
    }
}
