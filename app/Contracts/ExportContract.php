<?php

namespace App\Contracts;

use App\Models\Game;

interface ExportContract
{
    const TEXT_TRANSFORM_LOWERCASE = 'lowercase';

    const TEXT_TRANSFORM_NONE = '';

    const TEXT_TRANSFORM_UPPERCASE = 'uppercase';

    /**
     * @param  array<Game>  $games
     * @param  array<array<string>>  $teams
     */
    public function generate(array $games, array $teams): string;
}
