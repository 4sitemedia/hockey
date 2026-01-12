<?php

namespace App\Models;

use App\Services\TeamScheduleService;

class TeamSchedule extends AbstractSchedule
{
    public function __construct(TeamScheduleService $teamScheduleService, string $value)
    {
        $this->games = $teamScheduleService->fetch($value);
    }
}
