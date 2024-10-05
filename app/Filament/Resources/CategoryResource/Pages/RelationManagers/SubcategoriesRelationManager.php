<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubcategoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'subcategories';
    protected static ?string $navigationLabel = 'Subcategorías';
    protected static ?string $modelLabel = 'Subcategoría';
    protected static ?string $pluralModelLabel = 'Subcategorías';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('sede')
                    ->label('Sede')
                    ->options([
                        'Medellin' => 'Medellín',
                        'Barranquilla' => 'Barranquilla',
                        'Ambas' => 'Ambas',
                    ])
                    ->default('Ambas')
                    ->required()
                    ->disabled(fn (callable $get) => $get('inherit_sede')),
                Forms\Components\Toggle::make('inherit_sede')
                    ->label('Heredar sede de la categoría')
                    ->default(true)
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, $livewire) {
                        if ($state) {
                            $set('sede', $livewire->ownerRecord->sede);
                        }
                    }),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('sede')
                    ->colors([
                        'primary' => 'Ambas',
                        'danger' => 'Medellin',
                        'warning' => 'Barranquilla',
                    ]),
                Tables\Columns\IconColumn::make('inherit_sede')
                    ->label('Hereda Sede')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}