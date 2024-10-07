<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\Pages\ViewTicketModal;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Navigation\NavigationItem;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Illuminate\Contracts\View\View;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $slug = 'tickets';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(fn () => Auth::id()),
                Forms\Components\TextInput::make('title')
                    ->label('Título del Ticket')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('category_id')
                    ->label('Categoría')
                    ->relationship('category', 'name')
                    ->required()
                    ->reactive(),
                Forms\Components\Select::make('subcategory_id')
                    ->label('Subcategoría')
                    ->relationship('subcategory', 'name')
                    ->options(function (callable $get) {
                        $categoryId = $get('category_id');
                        if ($categoryId) {
                            return \App\Models\Subcategory::where('category_id', $categoryId)->pluck('name', 'id');
                        }
                        return [];
                    })
                    ->visible(fn (callable $get) => $get('category_id') !== null),
                Forms\Components\Textarea::make('description')
                    ->label('Descripción')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('file_path')
                    ->label('Adjuntar archivo')
                    ->disk('public')
                    ->directory('ticket-files')
                    ->acceptedFileTypes(['image/*', 'application/pdf'])
                    ->maxSize(5120),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nombre del Usuario')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categoría')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subcategory.name')
                    ->label('Subcategoría')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'primary' => 'abierto',
                        'warning' => 'en_progreso',
                        'success' => 'cerrado',
                    ])
                    ->label('Estado')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'abierto' => 'Abierto',
                        'en_progreso' => 'En Progreso',
                        'cerrado' => 'Cerrado',
                    ]),
            ])
            ->actions([
                Action::make('view')
                    ->label('Ver')
                    ->icon('heroicon-o-eye')
                    ->form(function (Ticket $record): array {
                        if ($record->status === 'abierto') {
                            return [
                                Forms\Components\Textarea::make('new_response')
                                    ->label('Nueva Respuesta')
                                    ->required(),
                            ];
                        }
                        return [];
                    })
                    ->modalHeading(fn (Ticket $record): string => "Ticket: {$record->title}")
                    ->modalContent(fn (Ticket $record): View => view(
                        'filament.resources.ticket-resource.pages.view-ticket-modal',
                        ['record' => $record]
                    ))
                    ->modalSubmitActionLabel(fn (Ticket $record): string => 
                        $record->status === 'abierto' ? 'Responder y Cerrar' : 'Cerrar'
                    )
                    ->modalWidth('7xl')
                    ->action(function (Ticket $record, array $data): void {
                        if (isset($data['new_response']) && $record->status === 'abierto') {
                            $record->response = $data['new_response'];
                            $record->status = 'cerrado';
                            $record->save();
                            
                            Notification::make()
                                ->title('Respuesta enviada y ticket cerrado')
                                ->success()
                                ->send();
                        }
                    })
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
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }

    public static function getNavigationItems(): array
    {
        return [
            NavigationItem::make('Tickets')
                ->icon('heroicon-o-ticket')
                ->url(static::getUrl('index'))
                ->sort(10),
            NavigationItem::make('Nuevo Ticket')
                ->icon('heroicon-o-plus-circle')
                ->url(static::getUrl('create'))
                ->sort(11),
        ];
    }
}