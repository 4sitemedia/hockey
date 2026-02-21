<?php

namespace App\Models;

use App\Services\TeamScheduleService;

class TeamSchedule extends AbstractSchedule
{
    public function __construct(TeamScheduleService $teamScheduleService, string $value)
    {
        $this->games = $teamScheduleService->fetch($value);
    }

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
