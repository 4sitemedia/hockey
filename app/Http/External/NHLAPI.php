<?php

namespace App\Http\External;

use Illuminate\Support\Facades\Http;

class NHLAPI
{
    /**
     * get the response for the given url
     *
     * @return array<string, mixed>
     */
    public function get(string $url): array
    {
        $response = Http::get($url);

        return $response->status() === 200 ? $response->json() : [];
    }
}
