<?php

namespace App\Livewire;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalUsersCard extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total de Usuarios', User::count())
                ->description('Usuarios registrados en el sistema')
                ->icon('heroicon-o-users')
                ->color('primary')
                ->extraAttributes([
                    'class' => 'cursor-pointer transition-all hover:scale-105 bg-primary-500 dark:bg-primary-400',
                    'wire:click' => 'redirectToUsers',
                ])
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->chartColor('primary'),
        ];
    }

    public function redirectToUsers(): void
    {
        $userResource = app(\App\Filament\Resources\UserResource::class);
        $url = $userResource::getUrl('index');
        $this->redirect($url);
    }
}