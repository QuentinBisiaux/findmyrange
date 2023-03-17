<?php

namespace App\Domain\Card;

use App\Domain\Position\Position;
use App\Domain\Tournament\Tournament;

class Card
{
    private string $rawCardsData;

    private string $cards;

    private bool $areCardsSuited;

    private string $rawCards;

    public function __construct(string $rawCardsData)
    {
        $this->rawCardsData = $rawCardsData;
        $this->initCards();
    }

    private function initCards(): void
    {
        $working = explode(' ', $this->rawCardsData);
        $working = substr($working[2] . ' ' .$working[3], 1, -2);
        $cards = explode(' ', $working);
        $this->rawCards = implode(' ', $cards);
        $this->areCardsSuited = $cards[0][1] === $cards[1][1];
        $card1 = substr($cards[0], 0, -1);
        $card2 = substr($cards[1], 0, -1);
        $this->cards = $this->sortCards($card1, $card2);
    }

    private function sortCards(string $card1, string $card2): string
    {
        if ($card1 === 'A') return $card1 . $card2;
        if ($card2 === 'A') return $card2 . $card1;
        if ($card1 === 'K') return $card1 . $card2;
        if ($card2 === 'K') return $card2 . $card1;
        if ($card1 === 'Q') return $card1 . $card2;
        if ($card2 === 'Q') return $card2 . $card1;
        if ($card1 === 'J') return $card1 . $card2;
        if ($card2 === 'J') return $card2 . $card1;
        if ($card1 === 'T') return $card1 . $card2;
        if ($card2 === 'T') return $card2 . $card1;
        return ($card2 > $card1) ? $card2 . $card1 : $card1 . $card2;
    }

    public function getCards(): string
    {
        return $this->areCardsSuited() ? $this->cards . 's' : $this->cards;
    }

    public function areCardsSuited(): bool
    {
        return $this->areCardsSuited;
    }

    public function getRawCardsData(): string
    {
        return $this->rawCardsData;
    }

    public function getRawCards(): string
    {
        return $this->rawCards;
    }

}