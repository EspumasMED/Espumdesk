<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SoftwareResource\Pages;
use App\Models\Software;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Navigation\NavigationItem;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\Enums\FontWeight;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class SoftwareResource extends Resource
{
    protected static ?string $model = Software::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Software';
    protected static ?string $modelLabel = 'Software';
    protected static ?string $pluralModelLabel = 'Software';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Inventario';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\TextInput::make('nombre')
                            ->required()
                            ->maxLength(255)
                            ->label('Nombre'),

                        Forms\Components\TextInput::make('version')
                            ->required()
                            ->maxLength(255)
                            ->label('Versión'),
                    ])->columns(2),

                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Select::make('tipo')
                            ->options([
                                'ERP' => 'ERP',
                                'CRM' => 'CRM',
                                'OFFICE' => 'Office',
                                'OTROS' => 'Otros'
                            ])
                            ->required()
                            ->label('Tipo'),

                        Forms\Components\Select::make('criticidad')
                            ->options([
                                '1' => 'Crítico',
                                '2' => 'Alto',
                                '3' => 'Medio',
                                '4' => 'Bajo'
                            ])
                            ->required()
                            ->label('Criticidad'),

                        Forms\Components\Toggle::make('requiere_capacitacion')
                            ->required()
                            ->label('Requiere Capacitación'),
                    ])->columns(3),

                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\DatePicker::make('fecha_renovacion')
                            ->label('Fecha de Renovación'),

                        Forms\Components\Toggle::make('estado')
                            ->required()
                            ->label('Estado'),
                    ])->columns(2),

                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Textarea::make('descripcion')
                            ->required()
                            ->label('Descripción'),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable()
                    ->sortable()
                    ->label('Nombre')
                    ->weight(FontWeight::Bold),

                Tables\Columns\TextColumn::make('version')
                    ->searchable()
                    ->sortable()
                    ->label('Versión'),

                Tables\Columns\TextColumn::make('tipo')
                    ->badge()
                    ->colors([
                        'primary' => fn($state): bool => $state === 'ERP',
                        'success' => fn($state): bool => $state === 'CRM',
                        'warning' => fn($state): bool => $state === 'OFFICE',
                        'gray' => fn($state): bool => $state === 'OTROS',
                    ])
                    ->sortable()
                    ->label('Tipo'),

                Tables\Columns\TextColumn::make('criticidad')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        '1' => 'Crítico',
                        '2' => 'Alto',
                        '3' => 'Medio',
                        '4' => 'Bajo',
                    })
                    ->colors([
                        'danger' => fn($state): bool => $state === '1',
                        'warning' => fn($state): bool => $state === '2',
                        'success' => fn($state): bool => $state === '3',
                        'gray' => fn($state): bool => $state === '4',
                    ])
                    ->sortable()
                    ->label('Criticidad'),

                Tables\Columns\IconColumn::make('requiere_capacitacion')
                    ->boolean()
                    ->label('Capacitación')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('fecha_renovacion')
                    ->date()
                    ->sortable()
                    ->label('Fecha Renovación')
                    ->toggleable(),

                Tables\Columns\IconColumn::make('estado')
                    ->boolean()
                    ->label('Estado')
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('tipo')
                    ->options([
                        'ERP' => 'ERP',
                        'CRM' => 'CRM',
                        'OFFICE' => 'Office',
                        'OTROS' => 'Otros'
                    ])
                    ->label('Tipo'),

                Tables\Filters\SelectFilter::make('criticidad')
                    ->options([
                        '1' => 'Crítico',
                        '2' => 'Alto',
                        '3' => 'Medio',
                        '4' => 'Bajo'
                    ])
                    ->label('Criticidad'),

                Tables\Filters\Filter::make('requiere_capacitacion')
                    ->query(fn(Builder $query): Builder => $query->where('requiere_capacitacion', true))
                    ->label('Requiere Capacitación'),

                Tables\Filters\Filter::make('activos')
                    ->query(fn(Builder $query): Builder => $query->where('estado', true))
                    ->label('Activos'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth('4xl'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->modalWidth('4xl'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSoftware::route('/'),
            'matriz' => Pages\AccessMatrix::route('/matriz'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationItems(): array
    {
        return [
            NavigationItem::make('Sotfware')
                ->icon('heroicon-o-rectangle-stack')
                ->url(static::getUrl('index'))
                ->sort(10),
            NavigationItem::make('Matriz de Accesos')
                ->icon('heroicon-o-table-cells')
                ->url(static::getUrl('matriz'))
                ->sort(11),
        ];
    }
}
