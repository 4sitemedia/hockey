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

    /**
     * get the schedule for the given value
     */
    abstract public function fetchSchedule(string $value): void;

    /**
     * convert the game data objects to arrays
     *
     * @return array<array<string, mixed>>
     */
    public function getGamesArray(): array
    {
        return array_map(function (Game $game) {
            return $game->toArray();
        }, $this->games);
    }
}
