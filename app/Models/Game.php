<?php

namespace App\Models;

use Carbon\Carbon;

class Game
{
    private int $awayTeamId;
    private Carbon $endTime;
    private int $gameType;
    private int $homeTeamId;
    private int $playoffGameNumber;
    private int $playoffRound;
    private string $recapLong;
    private string $recapShort;
    private Carbon $startTime;
    private string $venue;

    /**
     * construct a game object
     *
     * @param int $awayTeamId
     * @param Carbon $endTime
     * @param int $gameType
     * @param int $homeTeamId
     * @param int $playoffGameNumber
     * @param int $playoffRound
     * @param string $recapLong
     * @param string $recapShort
     * @param Carbon $startTime
     * @param string $venue
     */
    function __construct(
        int    $awayTeamId,
        Carbon $endTime,
        int    $gameType,
        int    $homeTeamId,
        int    $playoffGameNumber,
        int    $playoffRound,
        string $recapLong,
        string $recapShort,
        Carbon $startTime,
        string $venue
    )
    {
        $this->awayTeamId = $awayTeamId;
        $this->endTime = $endTime;
        $this->gameType = $gameType;
        $this->homeTeamId = $homeTeamId;
        $this->playoffGameNumber = $playoffGameNumber;
        $this->playoffRound = $playoffRound;
        $this->recapLong = $recapLong;
        $this->recapShort = $recapShort;
        $this->startTime = $startTime;
        $this->venue = $venue;
    }

    /**
     * return the game data as an array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'awayTeamId' => $this->awayTeamId,
            'endTime' => $this->endTime,
            'gameType' => $this->gameType,
            'homeTeamId' => $this->homeTeamId,
            'playoffGameNumber' => $this->playoffGameNumber,
            'playoffRound' => $this->playoffRound,
            'recapLong' => $this->recapLong,
            'recapShort' => $this->recapShort,
            'startTime' => $this->startTime,
            'venue' => $this->venue,
        ];
    }
}
