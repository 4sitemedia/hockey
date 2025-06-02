<?php

namespace App\Models;

use App\Http\External\NHLTeams;
use Illuminate\Support\Facades\Cache;

class Teams
{
    private array $teams = [];

    /***
     * get the teams from the api
     *
     * @return void
     */
    public function fetchTeams(): void
    {
        $this->teams = Cache::remember('teams', 86400, function () {
            $teamsAPI = new NHLTeams();
            $response = $teamsAPI->getTeams();

            $teams = $teamsAPI->parseResponse($response);

            return $this->sortTeams($teams);
        });
    }

    /**
     * get an array of teams mapped by id
     *
     * @return array
     */
    public function getTeamMap(): array
    {
        $map = [];

        foreach ($this->teams as $team) {
            $map[$team->id] = $team->toArray();
        }

        return $map;
    }

    /**
     * return the team data as an array
     *
     * @return array
     */
    public function getTeamsArray(): array
    {
        return array_map(function (Team $team) {
            return $team->toArray();
        }, $this->teams);
    }

    /**
     * sort the teams based on the given field
     *
     * @param array $teams
     * @param string $field
     * @return array
     */
    public function sortTeams(array $teams, string $field = 'fullName'): array
    {
        if (!in_array($field, ['code', 'fullName', 'id', 'location', 'name'])) {
            return $teams;
        }

        usort($teams, function ($team1, $team2) use ($field) {
            return $team1->$field <=> $team2->$field;
        });

        return $teams;
    }

}
