<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class Rating extends Field
{
    protected string $view = 'filament.forms.components.rating';

    protected int $maxRating = 5;

    public function maxRating(int $rating): static
    {
        $this->maxRating = $rating;

        return $this;
    }

    public function getMaxRating(): int
    {
        return $this->maxRating;
    }
}