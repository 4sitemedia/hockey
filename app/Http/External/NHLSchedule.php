<?php

namespace App\Http\External;

use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class NHLSchedule
{
    public const DATE_URL = 'https://api-web.nhle.com/v1/score/%s';
    public const TEAM_URL = 'https://api-web.nhle.com/v1/club-schedule-season/%s/now';

    /**
     * get the schedule for the given date
     *
     * @param string $date
     * @return array
     */
    public function getDateSchedule(string $date): array
    {
        $url = sprintf(self::DATE_URL, $date);
        $response = Http::get($url);

        return $response->json();
    }

    /**
     * get the schedule for the given team
     *
     * @param string $team
     * @return array
     */
    public function getTeamSchedule(string $team): array
    {
        $url = sprintf(self::TEAM_URL, $team);
        $response = Http::get($url);

        return $response->json();
    }

    /**
     * @param array $response
     * @return array
     */
    public function parseResponse(array $response): array
    {
        if (!isset($response['games'])) {
            return [];
        }

        $games = [];

        foreach ($response['games'] as $game) {
            $startTime = new Carbon($game['startTimeUTC']);
            $endTime = new Carbon($game['startTimeUTC']);
            $endTime->addHour(3);
            $playoffGameNumber = 0;
            $playoffRound = 0;

            if (array_key_exists('seriesStatus', $game)) {
                $playoffGameNumber = intval($game['seriesStatus']['gameNumberOfSeries']);
                $playoffRound = intval($game['seriesStatus']['round']);
            }

            $games[] =
                new Game(
                    awayTeamId: intval($game['awayTeam']['id']),
                    endTime: $endTime,
                    gameType: intval($game['gameType']),
                    homeTeamId: intval($game['homeTeam']['id']),
                    playoffGameNumber: $playoffGameNumber,
                    playoffRound: $playoffRound,
                    recapLong: array_key_exists('condensedGame', $game) ? 'https://www.nhl.com' . $game['condensedGame'] : '',
                    recapShort: array_key_exists('threeMinRecap', $game) ? 'https://www.nhl.com' . $game['threeMinRecap'] : '',
                    startTime: $startTime,
                    venue: $game['venue']['default']
                );
        }

        return $games;
    }
}
