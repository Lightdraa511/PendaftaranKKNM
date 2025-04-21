<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendaftaranKknResource\Pages;
use App\Filament\Resources\PendaftaranKknResource\RelationManagers;
use App\Models\PendaftaranKkn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PendaftaranKknResource extends Resource
{
    protected static ?string $model = PendaftaranKkn::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Pendaftaran KKN';

    protected static ?string $modelLabel = 'Pendaftaran KKN';

    protected static ?string $pluralModelLabel = 'Pendaftaran KKN';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('mahasiswa_id')
                    ->relationship('mahasiswa', 'nama')
                    ->required()
                    ->label('Mahasiswa'),
                Forms\Components\Select::make('tempat_kkn_id')
                    ->relationship('tempatKkn', 'nama_tempat')
                    ->required()
                    ->label('Tempat KKN'),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    ])
                    ->required()
                    ->label('Status'),
                Forms\Components\TextInput::make('no_pendaftaran')
                    ->required()
                    ->label('Nomor Pendaftaran'),
                Forms\Components\TextInput::make('total_pembayaran')
                    ->required()
                    ->numeric()
                    ->label('Total Pembayaran'),
                Forms\Components\Select::make('status_pembayaran')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Lunas',
                        'failed' => 'Gagal',
                    ])
                    ->required()
                    ->label('Status Pembayaran'),
                Forms\Components\TextInput::make('order_id')
                    ->label('Order ID'),
                Forms\Components\TextInput::make('snap_token')
                    ->label('Snap Token'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mahasiswa.nama')
                    ->searchable()
                    ->sortable()
                    ->label('Mahasiswa'),
                Tables\Columns\TextColumn::make('tempatKkn.nama_tempat')
                    ->searchable()
                    ->sortable()
                    ->label('Tempat KKN'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    })
                    ->label('Status'),
                Tables\Columns\TextColumn::make('no_pendaftaran')
                    ->searchable()
                    ->label('Nomor Pendaftaran'),
                Tables\Columns\TextColumn::make('total_pembayaran')
                    ->money('IDR')
                    ->sortable()
                    ->label('Total Pembayaran'),
                Tables\Columns\TextColumn::make('status_pembayaran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'failed' => 'danger',
                    })
                    ->label('Status Pembayaran'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListPendaftaranKkns::route('/'),
            'create' => Pages\CreatePendaftaranKkn::route('/create'),
            'edit' => Pages\EditPendaftaranKkn::route('/{record}/edit'),
        ];
    }
}
