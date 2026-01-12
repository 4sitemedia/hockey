<?php

namespace App\Http\Controllers;

use App\Models\DateSchedule;
use App\Models\Teams;
use App\Services\DateScheduleService;
use App\Services\TeamsService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class ScheduleController extends Controller
{
    /**
     * render the schedule for the given date
     */
    public function index(Request $request, DateScheduleService $dateScheduleService, TeamsService $teamsService, string $date = 'now'): Response
    {
        $teams = new Teams($teamsService);

        $request->merge(['date' => $date]);

        try {
            $request->validate([
                'date' => 'date',
            ]);
        } catch (ValidationException $exception) {
            $date = 'now';
        }

        $schedule = new DateSchedule($dateScheduleService, $date);

        return Inertia::render('Schedule', [
            'dates' => $schedule->getDates(),
            'games' => $schedule->getGamesArray(),
            'teamMap' => $teams->getTeamMap(),
        ]);
    }
}
