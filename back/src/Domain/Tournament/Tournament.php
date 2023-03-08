<?php

namespace App\Domain\Tournament;

class Tournament
{

    private string $id;

    private int $numberOfPlayers;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getNumberOfPlayers(): int
    {
        return $this->numberOfPlayers;
    }

    public function setNumberOfPlayers(int $numberOfPlayers): void
    {
        $this->numberOfPlayers = $numberOfPlayers;
    }


}