<?php

namespace App\Filament\Resources\SoftwareResource\Pages;

use App\Filament\Resources\SoftwareResource;
use App\Models\User;
use App\Models\Software;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class AccessMatrix extends Page implements HasForms
{
    use InteractsWithForms;
    use WithPagination;

    protected static string $resource = SoftwareResource::class;
    protected static string $view = 'filament.resources.software-resource.pages.access-matrix';
    protected static ?string $title = 'Matriz de Accesos';

    public ?array $data = [];
    public $selectedArea = null;
    public $selectedSede = null;
    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedArea' => ['except' => ''],
        'selectedSede' => ['except' => '']
    ];

    public function mount(): void
    {
        static::authorizeResourceAccess();
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('search')
                    ->label('Buscar Usuario')
                    ->placeholder('Ingrese nombre de usuario')
                    ->live()
                    ->debounce(500)
                    ->afterStateUpdated(fn() => $this->filterUsers()),

                Select::make('selectedArea')
                    ->options(
                        fn() => DB::table('users')
                            ->whereNotNull('area')
                            ->distinct()
                            ->pluck('area', 'area')
                            ->toArray()
                    )
                    ->label('Área')
                    ->live()
                    ->searchable()
                    ->afterStateUpdated(fn() => $this->filterUsers()),

                Select::make('selectedSede')
                    ->options(
                        fn() => DB::table('users')
                            ->whereNotNull('sede')
                            ->distinct()
                            ->pluck('sede', 'sede')
                            ->toArray()
                    )
                    ->label('Sede')
                    ->live()
                    ->searchable()
                    ->afterStateUpdated(fn() => $this->filterUsers()),
            ])
            ->columns(3);
    }

    public function getUsers(): Collection
    {
        $query = User::query();

        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%");
        }

        if ($this->selectedArea) {
            $query->where('area', $this->selectedArea);
        }

        if ($this->selectedSede) {
            $query->where('sede', $this->selectedSede);
        }

        return $query->orderBy('name')->get();
    }

    public function getSoftware(): Collection
    {
        return Software::query()->orderBy('nombre')->get();
    }

    public function updated($field)
    {
        if ($field === 'search' || $field === 'selectedArea' || $field === 'selectedSede') {
            $this->filterUsers();
        }
    }

    protected function filterUsers(): void
    {
        $formData = $this->form->getState();
        $this->selectedArea = $formData['selectedArea'] ?? null;
        $this->selectedSede = $formData['selectedSede'] ?? null;
        $this->search = $formData['search'] ?? '';
    }

    public function updateAccess(int $userId, int $softwareId): void
    {
        $user = User::find($userId);
        $software = Software::find($softwareId);

        if (!$user || !$software) {
            return;
        }

        $pivotData = $user->software()->where('software_id', $softwareId)->first()?->pivot;

        if ($pivotData) {
            $user->software()->updateExistingPivot($softwareId, [
                'has_access' => !$pivotData->has_access
            ]);
        } else {
            $user->software()->attach($softwareId, [
                'has_access' => true,
                'fecha_asignacion' => now(),
            ]);
        }
    }
}
