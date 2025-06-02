<?php

namespace App\Models;

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
     *
     * @param bool $active
     * @param string $code
     * @param string $fullName
     * @param int $id
     * @param string $location
     * @param string $name
     */
    function __construct(bool $active, string $code, string $fullName, int $id, string $location, string $name)
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
            'active' => $this->active,
            'code' => $this->code,
            'fullName' => $this->fullName,
            'id' => $this->id,
            'location' => $this->location,
            'name' => $this->name,
        ];
    }
}
