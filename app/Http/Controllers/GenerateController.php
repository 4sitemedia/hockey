<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Teams;
use App\Services\ExportICal;
use App\Services\TeamsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GenerateController extends Controller
{
    public function index(Request $request, ExportICal $export, TeamsService $teamsService): Response
    {
        $teams = new Teams($teamsService);

        $export->setOptions(
            exportLocation: filter_var($request->post('include_team_location'), FILTER_VALIDATE_BOOL),
            exportName: filter_var($request->post('include_team_name'), FILTER_VALIDATE_BOOL),
            exportVenue: filter_var($request->post('include_team_venue'), FILTER_VALIDATE_BOOL),
            team: $request->post('team'),
            textTransform: $request->post('transform_text', ''),
        );

        $gameIds = json_decode($request->post('games'));
        $games = [];

        foreach ($gameIds as $gameId) {
            $game = Cache::get("game-$gameId");

            if ($game instanceof Game) {
                $games[] = $game;
            }
        }

        $file = $export->generate($games, $teams->getTeamMap());

        return Inertia::render('Teams', [
            'file' => $file,
        ]);
    }

    public function download(Request $request, string $file): StreamedResponse
    {
        return Storage::download($file, 'schedule.ical');
    }
}
