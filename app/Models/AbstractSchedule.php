<?php

namespace App\Models;

abstract class AbstractSchedule
{
    protected array $games = [];

    abstract public function fetchSchedule(string $value): void;

    /**
     * convert the game data to arrays
     *
     * @return array
     */
    public function getGamesArray(): array
    {
        return array_map(function (Game $game) {
            return $game->toArray();
        }, $this->games);
    }
}
