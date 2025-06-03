<?php

namespace App\Models;

use App\Http\External\NHLSchedule;
use Illuminate\Support\Facades\Cache;

class TeamSchedule extends AbstractSchedule
{
    /**
     * get the schedule for the given team from the api
     */
    public function fetchSchedule(string $value): void
    {
        $scheduleAPI = new NHLSchedule;

        $response = Cache::remember("$value-schedule", 86400, function () use ($scheduleAPI, $value) {
            return $scheduleAPI->getTeamSchedule($value);
        });

        $this->games = $scheduleAPI->parseResponse($response);
    }
}
