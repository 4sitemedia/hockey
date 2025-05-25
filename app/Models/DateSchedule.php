<?php

namespace App\Models;

use App\Http\External\NHLSchedule;
use Illuminate\Support\Facades\Cache;

class DateSchedule extends AbstractSchedule
{
    protected string $currentDate = '';
    protected string $nextDate = '';
    protected string $previousDate = '';

    /**
     * get the schedule for the given date from the api
     *
     * @param string $value
     * @return void
     */
    public function fetchSchedule(string $value): void
    {
        $scheduleAPI = new NHLSchedule();

        $response = Cache::remember("$value-scores", 14400, function () use ($scheduleAPI, $value) {
            return $scheduleAPI->getDateSchedule($value);
        });

        $this->games = $scheduleAPI->parseResponse($response);
        $this->currentDate = array_key_exists('currentDate', $response) ? $response['currentDate'] : '';
        $this->nextDate = array_key_exists('nextDate', $response) ? $response['nextDate'] : '';
        $this->previousDate = array_key_exists('prevDate', $response) ? $response['prevDate'] : '';
    }

    /**
     * get the dates related to the most recent request
     *
     * @return array
     */
    public function getDates(): array
    {
        return [
            'previousDate' => $this->previousDate,
            'currentDate' => $this->currentDate,
            'nextDate' => $this->nextDate,
        ];
    }
}
