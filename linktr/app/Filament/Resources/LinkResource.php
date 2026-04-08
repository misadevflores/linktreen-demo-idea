<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LinkResource\Pages;
use App\Models\Link;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Forms\Get;

class LinkResource extends Resource
{
    protected static ?string $model = Link::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-link';

    protected static ?string $navigationLabel = 'Links';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Información del Link')
                ->schema([
                    Select::make('store_id')
                        ->relationship('store', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->disabled(),
                    TextInput::make('titulo')
                        ->required()
                        ->maxLength(255),
                    Select::make('tipo')
                        ->options([
                            'url' => 'URL Externa',
                            'pdf' => 'PDF',
                            'excel' => 'Excel',
                        ])
                        ->required(),
                    TextInput::make('path_o_url')
                        ->label('URL o Path')
                        ->required()
                        ->url()
                        ->visible(fn (Get $get): bool => $get('tipo') === 'url'),
                    FileUpload::make('path_o_url')
                        ->label('Archivo')
                        ->disk('stores_docs')
                        ->directory('docs')
                        ->acceptedFileTypes([
                            'application/pdf',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel',
                        ])
                        ->visible(fn (Get $get): bool => $get('tipo') !== 'url')
                        ->required(fn (Get $get): bool => $get('tipo') !== 'url'),
                    TextInput::make('orden')
                        ->numeric()
                        ->default(0)
                        ->required(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('store.name')
                    ->searchable(),
                TextColumn::make('titulo')
                    ->searchable(),
                BadgeColumn::make('tipo')
                    ->colors([
                        'primary' => 'url',
                        'warning' => 'pdf',
                        'success' => 'excel',
                    ]),
                TextColumn::make('path_o_url')
                    ->label('Path/URL'),
                TextColumn::make('orden'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => Pages\ListLinks::route('/'),
            'create' => Pages\CreateLink::route('/create'),
            'edit' => Pages\EditLink::route('/{record}/edit'),
        ];
    }
}

