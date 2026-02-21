<?php

namespace App\Models;

use App\Services\TeamsService;

/**
 * @property array<Team> $name
 */
class Teams
{
    /**
     * @var array<Team>
     */
    private array $teams = [];

    public function __construct(TeamsService $teamsService)
    {
        $this->teams = $this->sortTeams($teamsService->fetch());
    }

    /**
     * get an array of the team ids
     *
     * @return array<int>
     */
    public function getTeamIds(): array
    {
        return array_map(function (Team $team) {
            return $team->id;
        }, $this->teams);
    }

    /**
     * get an array of teams mapped by id
     *
     * @return array<int, array<string, mixed>>
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
     * @return array<array<string, mixed>>
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
     * @param  array<Team>  $teams
     * @return array<Team>
     */
    public function sortTeams(array $teams, string $field = 'fullName'): array
    {
        if (! in_array($field, ['code', 'fullName', 'id', 'location', 'name'])) {
            return $teams;
        }

        usort($teams, function ($team1, $team2) use ($field) {
            return $team1->$field <=> $team2->$field;
        });

        return $teams;
    }
}
