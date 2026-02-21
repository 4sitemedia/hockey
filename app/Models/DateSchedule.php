<?php

namespace App\Models;

use App\Services\DateScheduleService;

/**
 * @property string $currentDate
 * @property string $nextDate
 * @property string $previousDate
 */
class DateSchedule extends AbstractSchedule
{
    private string $date;

    private DateScheduleService $dateScheduleService;

    public function __construct(DateScheduleService $dateScheduleService, string $value)
    {
        $this->date = $value;
        $this->dateScheduleService = $dateScheduleService;
        $this->games = $this->dateScheduleService->fetch($this->date);
    }

    /**
     * get the dates related to the most recent request
     *
     * @return array<string, string>
     */
    public function getDates(): array
    {
        return $this->dateScheduleService->dates($this->date);
    }

    /**
     * convert the valid nhl game data objects to arrays
     *
     * @return array<array<string, mixed>>
     */
    public function getGamesArray(Teams $teams): array
    {
        $teamIds = $teams->getTeamIds();

        return array_reduce($this->games, function (array $games, Game $game) use ($teamIds) {
            if (in_array($game->awayTeamId, $teamIds) && in_array($game->homeTeamId, $teamIds)) {
                $games[] = $game->toArray();
            }

            return $games;
        }, []);
    }
}
