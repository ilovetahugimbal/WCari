<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ToiletResource\Pages;
use App\Models\Toilet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ToiletResource extends Resource
{
    protected static ?string $model = Toilet::class;
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Toilets';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('address')
                ->required(),
            Forms\Components\Textarea::make('description')
                ->rows(3),
            Forms\Components\TimePicker::make('open'),
            Forms\Components\TimePicker::make('close'),
            Forms\Components\TextInput::make('fee'),
            Forms\Components\FileUpload::make('photo')
                ->image()
                ->directory('toilets'),
            Forms\Components\TextInput::make('contact'),
            Forms\Components\TagsInput::make('facilities')
                ->separator(','),
            Forms\Components\TagsInput::make('access')
                ->separator(','),
            Forms\Components\TextInput::make('latitude')
                ->numeric(),
            Forms\Components\TextInput::make('longitude')
                ->numeric(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TagsColumn::make('facilities'),
                Tables\Columns\TagsColumn::make('access'),
                Tables\Columns\ImageColumn::make('photo'),
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
            'index' => Pages\ListToilets::route('/'),
            'create' => Pages\CreateToilet::route('/create'),
            'edit' => Pages\EditToilet::route('/{record}/edit'),
        ];
    }
}