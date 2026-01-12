<?php

namespace App\Contracts;

use App\Models\Game;

interface ScheduleContract
{
    /**
     * @return array<Game>
     */
    public function fetch(string $value): array;

    /**
     * @param  array<string, mixed>  $response
     * @return array<Game>
     */
    public function parseResponse(array $response): array;
}
