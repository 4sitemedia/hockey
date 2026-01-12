<?php

namespace App\Http\External;

class NHLTeams extends NHLAPI
{
    public const URL = 'https://api.nhle.com/stats/rest/en/franchise?include=lastSeason.id&include=teams';

    /**
     * get the teams
     *
     * @return array<string, array<string, mixed>>
     */
    public function getTeams(): array
    {
        return $this->get(self::URL);
    }
}
