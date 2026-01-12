<?php

namespace App\Contracts;

use App\Models\Team;

interface TeamsContract
{
    /**
     * @return array<Team>
     */
    public function fetch(): array;

    /**
     * @param  array<string, array<string, mixed>>  $response
     * @return array<Team>
     */
    public function parseResponse(array $response): array;
}
