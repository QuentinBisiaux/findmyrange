<?php

namespace App\Domain\Position;

class Position
{
    const CONST_POSITION_NAMES =
        [
            3   => ['BTN, SB, BB'],
            4   => ['UTG', 'BTN', 'SB', 'BB'],
            6   => ['UTG', 'HJ', 'CO', 'BTN', 'SB', 'BB'],
            7   => ['UTG', 'UTG+1', 'HJ', 'CO', 'BTN', 'SB', 'BB'],
            8   => ['UTG', 'UTG+1', 'MP', 'HJ', 'CO', 'BTN', 'SB', 'BB'],
            9   => ['UTG', 'UTG+1', 'MP', 'MP+1', 'HJ', 'CO', 'BTN', 'SB', 'BB']
        ];

    public static function getPosition(int $numberOfPlayers, $position): string
    {
        return self::CONST_POSITION_NAMES[$numberOfPlayers][$position];
    }

}