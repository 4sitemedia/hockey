<?php

namespace App\Http\Controllers;

use App\Models\Teams;
use App\Models\TeamSchedule;
use Inertia\Inertia;
use Inertia\Response;

class TeamController extends Controller
{
    /***
     * render the teams page
     *
     * @return Response
     */
    public function index(): Response
    {
        $teams = new Teams;
        $teams->fetchTeams();

        return Inertia::render('Teams', [
            'teamMap' => $teams->getTeamMap(),
            'teams' => $teams->getTeamsArray(),
        ]);
    }

    /**
     * return the games for the given team
     */
    public function games($team): Response
    {
        $games = [];

        if (! empty($team)) {
            $schedule = new TeamSchedule;
            $schedule->fetchSchedule($team);

            $games = $schedule->getGamesArray();
        }

        return Inertia::render('Teams', [
            'games' => $games,
        ]);
    }
}
