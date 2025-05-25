<?php

namespace App\Http\External;

use App\Models\Team;
use Illuminate\Support\Facades\Http;

class NHLTeams
{
    public const URL = 'https://api.nhle.com/stats/rest/en/franchise?include=lastSeason.id&include=teams';

    /**
     * get the teams
     *
     * @return array
     */
    public function getTeams(): array
    {
        $response = Http::get(self::URL);

        return $response->json();
    }

    /**
     * parse given teams api response
     *
     * @param array $response
     * @return array
     */
    public function parseResponse(array $response): array
    {
        if (!isset($response['data'])) {
            return [];
        }

        $teams = [];

        foreach ($response['data'] as $teamData) {
            if (!empty($teamData['lastSeason'])) {
                continue;
            }

            $team = array_find($teamData['teams'], function (array $element) use ($teamData) {
                return $element['fullName'] === $teamData['fullName'];
            });

            if (!isset($team)) {
                continue;
            }

            $teams[] = new Team($team['triCode'], $team['id'], $teamData['teamPlaceName'], $teamData['teamCommonName']);
        }

        return $teams;
    }
}
