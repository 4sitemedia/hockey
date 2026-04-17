<?php

namespace App\Services;

use App\Http\External\NHLSchedule;
use App\Models\Game;
use Illuminate\Support\Facades\Cache;

class TeamScheduleService extends AbstractScheduleService
{
    /**
     * fetch the schedule for the given team from the api or cache
     *
     * @return array<Game>
     */
    public function fetch(string $value): array
    {
        $response = Cache::remember("schedule-$value", config('app.cache_timeout'), function () use ($value) {
            $scheduleAPI = new NHLSchedule;

            return $scheduleAPI->getTeamSchedule($value);
        });

        return $this->parseResponse($response);
    }
}
