<?php

namespace App\Models;

/**
 * @property array<Game> $games
 */
abstract class AbstractSchedule
{
    /**
     * @var array<Game>
     */
    protected array $games = [];
}
