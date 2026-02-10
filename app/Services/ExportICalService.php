<?php

namespace App\Services;

use App\Contracts\ExportContract;
use App\Models\Game;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ExportICalService implements ExportContract
{
    const DATE_FORMAT = 'Ymd\THis\Z';

    protected bool $exportLocation;

    protected bool $exportName;

    protected bool $exportVenue;

    protected Carbon $now;

    protected ?string $team;

    protected string $textTransform;

    public function __construct()
    {
        $this->now = Carbon::now();
    }

    /**
     * generate the icalendar footer
     *
     * @return array<string>
     */
    public function buildFooter(): array
    {
        return [
            'END:VCALENDAR',
        ];
    }

    /**
     * generate the icalender event for the given game
     *
     * @param  array<array<string>>  $teams
     * @return array<string>
     */
    public function buildGame(Game $game, array $teams): array
    {
        $awayTeam = $teams[$game->awayTeamId];
        $homeTeam = $teams[$game->homeTeamId];

        $game = Cache::get("game-{$game->gameId}");

        $event = [
            'BEGIN:VEVENT',
            'SUMMARY:'.$this->buildSummary($awayTeam, $homeTeam),
            'DTSTART:'.$game->startTime->format(self::DATE_FORMAT),
            'DTEND:'.$game->endTime->format(self::DATE_FORMAT),
            'DTSTAMP:'.$this->now->format(self::DATE_FORMAT),
        ];

        if ($this->exportVenue) {
            $event[] = 'LOCATION:'.$this->transformText($game->venue);
        }

        $event[] = 'UID:'.$game->gameId;
        $event[] = 'END:VEVENT';

        return $event;
    }

    /**
     * generate the icalendar header
     *
     * @return array<string>
     */
    public function buildHeader(): array
    {
        return [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//4SiteMedia LLC//NONSGML NHL Schedule//EN',
        ];
    }

    /**
     * generate the event summary
     *
     * @param  array<string>  $awayTeam
     * @param  array<string>  $homeTeam
     */
    public function buildSummary(array $awayTeam, array $homeTeam): string
    {
        $pieces = [];

        if ($this->exportLocation && $this->exportName) {
            $pieces[] = $awayTeam['fullName'];
            $pieces[] = $homeTeam['fullName'];
        } elseif ($this->exportLocation) {
            $pieces[] = $awayTeam['location'];
            $pieces[] = $homeTeam['location'];
        } elseif ($this->exportName) {
            $pieces[] = $awayTeam['name'];
            $pieces[] = $homeTeam['name'];
        }

        $summary = implode(' at ', $pieces);

        return $this->transformText($summary);
    }

    /**
     * generate the icalendar import file for the given games
     *
     * @param  array<Game>  $games
     * @param  array<array<string>>  $teams
     *
     * @throws Exception
     */
    public function generate(array $games, array $teams): string
    {
        $resource = fopen('php://memory', 'w');

        if ($resource === false) {
            throw new Exception('Error opening file');
        }

        foreach ($this->buildHeader() as $row) {
            fwrite($resource, $row.PHP_EOL);
        }

        foreach ($games as $game) {
            foreach ($this->buildGame($game, $teams) as $row) {
                fwrite($resource, $row.PHP_EOL);
            }
        }

        foreach ($this->buildFooter() as $row) {
            fwrite($resource, $row.PHP_EOL);
        }

        rewind($resource);

        $file = Str::uuid();
        Storage::disk('local')->put($file, stream_get_contents($resource));

        return $file;
    }

    public function setOptions(bool $exportLocation, bool $exportName, bool $exportVenue, ?string $team, string $textTransform): void
    {
        $this->exportLocation = $exportLocation;
        $this->exportName = $exportName;
        $this->exportVenue = $exportVenue;
        $this->team = $team;

        if (in_array($textTransform, [ExportContract::TEXT_TRANSFORM_LOWERCASE, ExportContract::TEXT_TRANSFORM_UPPERCASE])) {
            $this->textTransform = $textTransform;
        } else {
            $this->textTransform = ExportContract::TEXT_TRANSFORM_NONE;
        }
    }

    public function transformText(string $text): string
    {
        if ($this->textTransform === ExportContract::TEXT_TRANSFORM_LOWERCASE) {
            return strtolower($text);
        }

        if ($this->textTransform === ExportContract::TEXT_TRANSFORM_UPPERCASE) {
            return strtoupper($text);
        }

        return $text;
    }
}
