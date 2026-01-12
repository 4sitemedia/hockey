<?php

namespace App\Http\External;

class NHLSchedule extends NHLAPI
{
    public const DATE_URL = 'https://api-web.nhle.com/v1/score/%s';

    public const TEAM_URL = 'https://api-web.nhle.com/v1/club-schedule-season/%s/now';

    /**
     * get the schedule for the given date
     *
     * @return array<string, mixed>
     */
    public function getDateSchedule(string $date): array
    {
        $url = sprintf(self::DATE_URL, $date);

        return $this->get($url);
    }

    /**
     * get the schedule for the given team
     *
     * @return array<string, mixed>
     */
    public function getTeamSchedule(string $team): array
    {
        $url = sprintf(self::TEAM_URL, $team);

        return $this->get($url);
    }
}
