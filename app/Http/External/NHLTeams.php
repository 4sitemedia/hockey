<?php

namespace App\Http\External;

use App\Models\Team;
use Illuminate\Support\Facades\Http;

class NHLTeams
{
    public const URL = 'https://api.nhle.com/stats/rest/en/franchise?include=lastSeason.id&include=teams';

    /**
     * get the teams
     */
    public function getTeams(): array
    {
        $response = Http::get(self::URL);

        return $response->json();
    }

    /**
     * parse given teams api response
     */
    public function parseResponse(array $response): array
    {
        if (! isset($response['data'])) {
            return [];
        }

        $teams = [];

        foreach ($response['data'] as $teamData) {
            if (! empty($teamData['lastSeason'])) {
                continue;
            }

            foreach ($teamData['teams'] as $team) {
                $teams[] = new Team(
                    active: $team['fullName'] === $teamData['fullName'],
                    code: $team['triCode'],
                    fullName: $team['fullName'],
                    id: $team['id'],
                    location: $teamData['teamPlaceName'],
                    name: $teamData['teamCommonName']
                );
            }
        }

        return $teams;
    }
}
