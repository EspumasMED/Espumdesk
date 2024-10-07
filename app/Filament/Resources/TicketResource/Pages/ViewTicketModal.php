<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Livewire\Component;
use Filament\Notifications\Notification;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;

class ViewTicketModal extends Component
{
    use InteractsWithForms;

    public Ticket $record;
    public ?array $data = [];

    public function mount(Ticket $record)
    {
        $this->record = $record;
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('response')
                    ->label('Respuesta')
                    ->required()
                    ->visible(fn () => $this->record->status !== 'cerrado'),
            ])
            ->statePath('data');
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->record)
            ->schema([
                TextEntry::make('title')->label('Título'),
                TextEntry::make('user.name')->label('Usuario'),
                TextEntry::make('category.name')->label('Categoría'),
                TextEntry::make('subcategory.name')->label('Subcategoría'),
                TextEntry::make('status')->label('Estado'),
                TextEntry::make('description')->label('Descripción'),
                TextEntry::make('response')->label('Respuesta')->visible(fn ($record) => !empty($record->response)),
            ]);
    }

    public function addResponse()
    {
        $data = $this->form->getState();

        $this->record->response = $data['response'];
        $this->record->status = 'en_progreso';
        $this->record->save();

        $this->form->fill();

        Notification::make()
            ->title('Respuesta enviada')
            ->success()
            ->send();

        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('filament.resources.ticket-resource.pages.view-ticket-modal');
    }
}