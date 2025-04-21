<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MahasiswaResource\Pages;
use App\Filament\Resources\MahasiswaResource\RelationManagers;
use App\Models\Mahasiswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class MahasiswaResource extends Resource
{
    protected static ?string $model = Mahasiswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Mahasiswa';

    protected static ?string $modelLabel = 'Mahasiswa';

    protected static ?string $pluralModelLabel = 'Mahasiswa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nim')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->label('NIM'),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->label('Nama Lengkap'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->label('Email'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->label('Password'),
                Forms\Components\TextInput::make('no_hp')
                    ->tel()
                    ->required()
                    ->label('Nomor HP'),
                Forms\Components\TextInput::make('fakultas')
                    ->required()
                    ->label('Fakultas'),
                Forms\Components\TextInput::make('prodi')
                    ->required()
                    ->label('Program Studi'),
                Forms\Components\Textarea::make('alamat')
                    ->required()
                    ->label('Alamat'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nim')
                    ->searchable()
                    ->sortable()
                    ->label('NIM'),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Lengkap'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->label('Email'),
                Tables\Columns\TextColumn::make('no_hp')
                    ->label('Nomor HP'),
                Tables\Columns\TextColumn::make('fakultas')
                    ->searchable()
                    ->sortable()
                    ->label('Fakultas'),
                Tables\Columns\TextColumn::make('prodi')
                    ->searchable()
                    ->sortable()
                    ->label('Program Studi'),
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
            'index' => Pages\ListMahasiswas::route('/'),
            'create' => Pages\CreateMahasiswa::route('/create'),
            'edit' => Pages\EditMahasiswa::route('/{record}/edit'),
        ];
    }
}
