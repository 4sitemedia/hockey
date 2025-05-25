<?php

namespace App\Models;

class Team
{
    private readonly string $code;
    private readonly int $id;
    private readonly string $location;
    private readonly string $name;

    /**
     * construct a team object
     *
     * @param string $code
     * @param int $id
     * @param string $location
     * @param string $name
     */
    function __construct(string $code, int $id, string $location, string $name)
    {
        $this->code = $code;
        $this->id = $id;
        $this->location = $location;
        $this->name = $name;
    }

    /**
     * magic getter to access team data
     *
     * @param string $property
     * @return mixed
     */
    public function __get(string $property): mixed
    {
        return $this->$property;
    }

    /**
     * return the team data as an array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'id' => $this->id,
            'location' => $this->location,
            'name' => $this->name,
        ];
    }
}
