<?php

namespace App\Http\Controllers;

use App\Models\Teams;
use App\Models\TeamSchedule;
use App\Services\TeamScheduleService;
use App\Services\TeamsService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TeamController extends Controller
{
    /***
     * render the teams page
     *
     * @param TeamsService $teamsService
     * @return Response
     */
    public function index(TeamsService $teamsService): Response
    {
        $teams = new Teams($teamsService);

        return Inertia::render('Teams', [
            'teamMap' => $teams->getTeamMap(),
            'teams' => $teams->getTeamsArray(),
        ]);
    }

    /**
     * return the games for the given team
     */
    public function games(Request $request, TeamScheduleService $teamScheduleService, string $team): Response
    {
        $request->merge(['team' => $team]);

        $validated = $request->validate([
            'team' => 'required',
        ]);

        $schedule = new TeamSchedule($teamScheduleService, $validated['team']);
        $games = $schedule->getGamesArray();

        return Inertia::render('Teams', [
            'games' => $games,
        ]);
    }
}
