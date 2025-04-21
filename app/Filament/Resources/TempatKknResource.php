<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TempatKknResource\Pages;
use App\Filament\Resources\TempatKknResource\RelationManagers;
use App\Models\TempatKkn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TempatKknResource extends Resource
{
    protected static ?string $model = TempatKkn::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationLabel = 'Tempat KKN';

    protected static ?string $modelLabel = 'Tempat KKN';

    protected static ?string $pluralModelLabel = 'Tempat KKN';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_tempat')
                    ->required()
                    ->label('Nama Tempat'),
                Forms\Components\TextInput::make('kecamatan')
                    ->required()
                    ->label('Kecamatan'),
                Forms\Components\TextInput::make('kabupaten')
                    ->required()
                    ->label('Kabupaten'),
                Forms\Components\TextInput::make('kuota')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->label('Kuota'),
                Forms\Components\Textarea::make('deskripsi')
                    ->required()
                    ->label('Deskripsi'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_tempat')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Tempat'),
                Tables\Columns\TextColumn::make('kecamatan')
                    ->searchable()
                    ->sortable()
                    ->label('Kecamatan'),
                Tables\Columns\TextColumn::make('kabupaten')
                    ->searchable()
                    ->sortable()
                    ->label('Kabupaten'),
                Tables\Columns\TextColumn::make('kuota')
                    ->numeric()
                    ->sortable()
                    ->label('Kuota'),
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
            'index' => Pages\ListTempatKkns::route('/'),
            'create' => Pages\CreateTempatKkn::route('/create'),
            'edit' => Pages\EditTempatKkn::route('/{record}/edit'),
        ];
    }
}
