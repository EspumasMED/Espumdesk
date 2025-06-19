<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentResource\Pages;
use App\Models\Equipment;
use App\Models\Provider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\Enums\FontWeight;
use Illuminate\Contracts\View\View;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Filament\Tables\Actions\Action;

class EquipmentResource extends Resource
{
    protected static ?string $model = Equipment::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';
    protected static ?string $navigationLabel = 'Equipos';
    protected static ?string $modelLabel = 'Equipo';
    protected static ?string $pluralModelLabel = 'Equipos';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Inventario';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Select::make('company')
                            ->options(Equipment::$companies)
                            ->required()
                            ->label('Empresa')
                            ->columnSpan(1),

                        Forms\Components\Select::make('provider_id')
                            ->relationship('provider', 'company_name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('company_name')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Empresa'),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Email'),
                                Forms\Components\TextInput::make('phone')
                                    ->tel()
                                    ->maxLength(255)
                                    ->label('Teléfono'),
                                Forms\Components\Select::make('belongs_to')
                                    ->options(Provider::$companies)
                                    ->required()
                                    ->label('Pertenece a'),
                                Forms\Components\Select::make('status')
                                    ->options(Provider::$statuses)
                                    ->required()
                                    ->default(Provider::STATUS_ACTIVE)
                                    ->label('Estado'),
                                Forms\Components\Textarea::make('notes')
                                    ->nullable()
                                    ->maxLength(65535)
                                    ->label('Notas'),
                                Forms\Components\FileUpload::make('contract_file')
                                    ->nullable()
                                    ->directory('provider-contracts')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->maxSize(5120)
                                    ->label('Contrato'),
                            ])
                            ->nullable()
                            ->label('Proveedor')
                            ->columnSpan(1),
                    ])->columns(2),

                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Nombre del equipo'),

                        Forms\Components\TextInput::make('model')
                            ->required()
                            ->maxLength(255)
                            ->label('Modelo'),

                        Forms\Components\TextInput::make('serial_number')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->label('Numero de Serie'),

                        Forms\Components\TextInput::make('brand')
                            ->required()
                            ->maxLength(255)
                            ->label('Marca'),
                    ])->columns(2),

                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options(Equipment::$statuses)
                            ->required()
                            ->default('available')
                            ->label('Estado'),

                        Forms\Components\TextInput::make('assigned_to')
                            ->maxLength(255)
                            ->nullable()
                            ->label('Asignado a'),

                        Forms\Components\TextInput::make('area')
                            ->maxLength(255)
                            ->nullable()
                            ->label('Area-Departamento'),
                    ])->columns(3),

                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\TextInput::make('disco')
                            ->maxLength(255)
                            ->nullable()
                            ->label('Disco'),

                        Forms\Components\TextInput::make('procesador')
                            ->maxLength(255)
                            ->nullable()
                            ->label('Procesador'),

                        Forms\Components\TextInput::make('ram')
                            ->maxLength(255)
                            ->nullable()
                            ->label('RAM'),

                        Forms\Components\TextInput::make('otros')
                            ->maxLength(255)
                            ->nullable()
                            ->label('Otros'),
                    ])->columns(4),

                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\FileUpload::make('delivery_record')
                            ->nullable()
                            ->directory('delivery-records')
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(5120)
                            ->label('Acta de Entrega'),
                    ])->columns(1),

                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->nullable()
                            ->maxLength(65535)
                            ->label('Notas'),
                    ])->columns(1),

                Forms\Components\Grid::make()
                    ->columns(1)
                    ->schema([
                        Forms\Components\Repeater::make('perifericos')
                            ->label('Periféricos')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('tipo_periferico')
                                    ->label('Tipo de Periférico')
                                    ->options([
                                        'Monitor' => 'Monitor',
                                        'Teclado' => 'Teclado',
                                        'Mouse' => 'Mouse',
                                        'Parlantes' => 'Parlantes',
                                        'Otros' => 'Otros periféricos',
                                    ])
                                    ->reactive()
                                    ->required(),

                                Forms\Components\TextInput::make('tipo_personalizado')
                                    ->label('Especificar si es Otro')
                                    ->visible(fn($get) => $get('tipo_periferico') === 'Otros')
                                    ->required(fn($get) => $get('tipo_periferico') === 'Otros'),

                                Forms\Components\TextInput::make('marca')
                                    ->required()
                                    ->label('Marca'),

                                Forms\Components\TextInput::make('numero_serie')
                                    ->required()
                                    ->label('Número de Serie'),
                            ])
                            ->columns(4)
                            ->defaultItems(0)
                            ->createItemButtonLabel('Agregar periférico')
                    ]),

                Forms\Components\Grid::make()
                    ->columns(1)
                    ->schema([
                        Forms\Components\Fieldset::make('CARACTERÍSTICAS Y ACTIVIDADES DEL MANTENIMIENTO')
                            ->relationship('caracteristicasMantenimiento')
                            ->schema([
                                Forms\Components\TextInput::make('periodicidad')
                                    ->required()
                                    ->label('Periodicidad'),

                                Forms\Components\TextInput::make('mantenimiento_fisico')
                                    ->required()
                                    ->label('Mantenimiento físico'),

                                Forms\Components\TextInput::make('mantenimiento_software')
                                    ->required()
                                    ->label('Mantenimiento al software'),
                            ])
                            ->columns(1)
                    ]),

                Forms\Components\Grid::make()
                    ->columns(1)
                    ->schema([
                        Forms\Components\Repeater::make('seguimientosPreventivos')
                            ->label('Seguimiento Mantenimiento Preventivo')
                            ->relationship()
                            ->schema([
                                Forms\Components\DatePicker::make('fecha_mantenimiento_programado')
                                    ->label('Fecha de mantenimiento programado')
                                    ->required(),

                                Forms\Components\DatePicker::make('fecha_realizacion')
                                    ->label('Fecha de realización'),

                                Forms\Components\TextInput::make('responsable')
                                    ->required()
                                    ->label('Responsable del mantenimiento'),

                                Forms\Components\Textarea::make('observaciones')
                                    ->label('Observaciones y/o recomendaciones')
                                    ->rows(2),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->createItemButtonLabel('Agregar mantenimiento preventivo')
                    ]),

                Forms\Components\Grid::make()
                    ->columns(1)
                    ->schema([
                        Forms\Components\Repeater::make('seguimientosCorrectivos')
                            ->label('Seguimiento Mantenimiento Correctivo')
                            ->relationship()
                            ->schema([
                                Forms\Components\DatePicker::make('fecha_realizacion')
                                    ->label('Fecha de realización')
                                    ->required(),

                                Forms\Components\Textarea::make('servicio_realizado')
                                    ->label('Servicio técnico realizado')
                                    ->required()
                                    ->rows(2),

                                Forms\Components\Textarea::make('repuestos')
                                    ->label('Repuestos utilizados')
                                    ->rows(2),

                                Forms\Components\TextInput::make('responsable')
                                    ->label('Responsable')
                                    ->required(),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->createItemButtonLabel('Agregar mantenimiento correctivo')
                    ])





            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => Equipment::$companies[$state])
                    ->colors([
                        'primary' => fn($state): bool => $state === 'espumas_medellin',
                        'warning' => fn($state): bool => $state === 'espumados_litoral',
                    ])
                    ->sortable()
                    ->label('Empresa'),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nombre')
                    ->weight(FontWeight::Bold),

                Tables\Columns\TextColumn::make('model')
                    ->searchable()
                    ->sortable()
                    ->label('Modelo'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => Equipment::$statuses[$state])
                    ->colors([
                        'success' => fn($state): bool => $state === 'available',
                        'primary' => fn($state): bool => $state === 'in_use',
                        'warning' => fn($state): bool => $state === 'maintenance',
                        'danger' => fn($state): bool => $state === 'repair',
                        'gray' => fn($state): bool => $state === 'retired',
                        'info' => fn($state): bool => $state === 'reserved',
                    ])
                    ->sortable()
                    ->label('Estado'),

                Tables\Columns\TextColumn::make('assigned_to')
                    ->searchable()
                    ->sortable()
                    ->label('Asignado a')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('provider.company_name')
                    ->sortable()
                    ->searchable()
                    ->label('Proveedor'),

                Tables\Columns\TextColumn::make('area')
                    ->sortable()
                    ->searchable()
                    ->label('Área')
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('company')
                    ->options(Equipment::$companies)
                    ->label('Empresa'),

                Tables\Filters\SelectFilter::make('provider')
                    ->relationship('provider', 'company_name')
                    ->searchable()
                    ->preload()
                    ->label('Proveedor'),

                Tables\Filters\SelectFilter::make('status')
                    ->options(Equipment::$statuses)
                    ->label('Estado'),

                Tables\Filters\Filter::make('has_delivery_record')
                    ->query(fn(Builder $query): Builder => $query->whereNotNull('delivery_record'))
                    ->label('Con Acta de Entrega'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth('4xl'),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('hoja_vida')
                    ->label('Hoja de vida')
                    ->icon('heroicon-o-eye')
                    ->modalHeading(fn(Equipment $record): string => "Hoja de vida del equipo: {$record->name}")
                    ->modalWidth('5xl')
                    ->modalContent(fn(Equipment $record): View => view('filament.resources.equipment-resource.pages.hoja-vida', [
                        'equipment' => $record,
                    ]))
                    ->modalFooterActions([
                        Tables\Actions\Action::make('cerrar')
                            ->label('Cerrar')
                            ->color('secondary')
                            ->action(fn() => null),
                    ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()->exports([
                        ExcelExport::make('Formulario')->fromForm()
                    ])
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
            'index' => Pages\ListEquipment::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
