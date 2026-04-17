<?php

namespace App\Services;

use App\Contracts\TeamsContract;
use App\Http\External\NHLTeams;
use App\Models\Team;
use Illuminate\Support\Facades\Cache;

class TeamsService implements TeamsContract
{
    /**
     * fetch an array of teams from the api or cache
     *
     * @return array<Team>
     */
    public function fetch(): array
    {
        return Cache::remember('teams', config('app.cache_timeout'), function (): array {
            $teamsAPI = new NHLTeams;
            $response = $teamsAPI->getTeams();

            return $this->parseResponse($response);
        });
    }

    /**
     * parse the given team api response
     *
     * @param  array<string, array<string, mixed>>  $response
     * @return array<Team>
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
