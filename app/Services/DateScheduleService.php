<?php

namespace App\Services;

use App\Http\External\NHLSchedule;
use App\Models\Game;
use Illuminate\Support\Facades\Cache;

class DateScheduleService extends AbstractScheduleService
{
    /**
     * return an array dates relative to the given date based on the api response
     *
     * @return array<string>
     */
    public function dates(string $value): array
    {
        $response = $this->getResponse($value);

        return [
            'previousDate' => array_key_exists('prevDate', $response) ? $response['prevDate'] : '',
            'currentDate' => array_key_exists('currentDate', $response) ? $response['currentDate'] : '',
            'nextDate' => array_key_exists('nextDate', $response) ? $response['nextDate'] : '',
        ];
    }

    /**
     * get the schedule for the given date from the api or cache
     *
     * @return array<string, mixed>
     */
    protected function getResponse(string $value): array
    {
        return Cache::remember("schedule-$value", 14400, function () use ($value) {
            $scheduleAPI = new NHLSchedule;

            return $scheduleAPI->getDateSchedule($value);
        });
    }

    /**
     * return an array of games scheduled on the given date
     *
     * @return array<Game>
     */
    public function fetch(string $value): array
    {
        $response = $this->getResponse($value);

        return $this->parseResponse($response);
    }
}
