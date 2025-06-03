<?php

namespace App\Http\Controllers;

use App\Models\DateSchedule;
use App\Models\Teams;
use Inertia\Inertia;
use Inertia\Response;

class ScheduleController extends Controller
{
    /**
     * render the schedule for the given date
     */
    public function index(?string $date = null): Response
    {
        $teams = new Teams;
        $teams->fetchTeams();

        try {
            $requestDate = new \DateTime($date);
            $date = $requestDate->format('Y-m-d');
        } catch (\Exception $exception) {
            $date = 'now';
        }

        $schedule = new DateSchedule;
        $schedule->fetchSchedule($date);

        return Inertia::render('Schedule', [
            'dates' => $schedule->getDates(),
            'games' => $schedule->getGamesArray(),
            'teamMap' => $teams->getTeamMap(),
        ]);
    }
}
