<?php

namespace App\Filament\Infolists\Components;

use Filament\Infolists\Components\TextEntry;
use Illuminate\Support\HtmlString;

class RatingEntry extends TextEntry
{
    protected function setUp(): void
    {
        parent::setUp();

        // Formateamos el estado para mostrar las estrellas
        $this->formatStateUsing(function ($state) {
            // Si no hay calificación, asignamos 5 por defecto
            $state = is_null($state) ? 5 : $state;

            $stars = '';
            for ($i = 1; $i <= 5; $i++) {
                $starClass = $i <= $state ? 'text-yellow-400' : 'text-gray-300';
                $stars .= "<svg class='w-5 h-5 inline-block {$starClass}' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor'><path d='M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z'/></svg>";
            }

            return new HtmlString($stars);
        });
    }
}
