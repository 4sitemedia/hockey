<?php

namespace App\Services;

use App\Contracts\ScheduleContract;
use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

abstract class AbstractScheduleService implements ScheduleContract
{
    abstract public function fetch(string $value): array;

    /**
     * parse the given schedule api response
     *
     * @param  array<string, mixed>  $response
     * @return array<Game>
     */
    public function parseResponse(array $response): array
    {
        if (! isset($response['games'])) {
            return [];
        }

        $games = [];

        foreach ($response['games'] as $game) {
            $gameId = intval($game['id']);
            $startTime = new Carbon($game['startTimeUTC']);
            $endTime = new Carbon($game['startTimeUTC']);
            $endTime->addHours(3);
            $playoffGameNumber = 0;
            $playoffRound = 0;

            if (array_key_exists('seriesStatus', $game)) {
                $playoffGameNumber = intval($game['seriesStatus']['gameNumberOfSeries']);
                $playoffRound = intval($game['seriesStatus']['round']);
            }

            $game = new Game(
                awayTeamId: intval($game['awayTeam']['id']),
                endTime: $endTime,
                gameId: $gameId,
                gameType: intval($game['gameType']),
                homeTeamId: intval($game['homeTeam']['id']),
                playoffGameNumber: $playoffGameNumber,
                playoffRound: $playoffRound,
                recapLong: array_key_exists('condensedGame', $game) ? 'https://www.nhl.com'.$game['condensedGame'] : '',
                recapShort: array_key_exists('threeMinRecap', $game) ? 'https://www.nhl.com'.$game['threeMinRecap'] : '',
                startTime: $startTime,
                venue: $game['venue']['default']
            );

            $games[] = $game;

            Cache::add("game-$gameId", $game, config('app.cache_timeout'));
        }

        return $games;
    }
}
