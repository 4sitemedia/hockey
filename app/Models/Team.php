<?php

namespace App\Models;

/**
 * @property-read bool $active
 * @property-read string $code
 * @property-read string $fullName
 * @property-read int $id
 * @property-read string $location
 * @property-read string $name
 */
class Team
{
    private readonly bool $active;

    private readonly string $code;

    private readonly string $fullName;

    private readonly int $id;

    private readonly string $location;

    private readonly string $name;

    /**
     * construct a team object
     */
    public function __construct(bool $active, string $code, string $fullName, int $id, string $location, string $name)
    {
        $this->active = $active;
        $this->code = $code;
        $this->fullName = $fullName;
        $this->id = $id;
        $this->location = $location;
        $this->name = $name;
    }

    /**
     * magic getter to access team data
     */
    public function __get(string $property): mixed
    {
        return $this->$property;
    }

    /**
     * return the team data as an array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'active' => $this->active,
            'code' => $this->code,
            'fullName' => $this->fullName,
            'id' => $this->id,
            'location' => $this->location,
            'name' => $this->name,
        ];
    }
}
