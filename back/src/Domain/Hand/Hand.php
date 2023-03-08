<?php

namespace App\Domain\Hand;

use App\Domain\Position\Position;
use App\Domain\Tournament\Tournament;

class Hand
{
    private array $rawHandData = [];

    private string $currentPlayer;

    private Tournament $tournament;

    private string $position;

    private array $preFlopAction;

    private string $cards;

    private bool $areCardsSuited;

    private bool $isHandRaisedByPlayerPreFlop = false;

    public function __construct(array $rawHandData)
    {
        $this->rawHandData = $rawHandData;
        $this->initTournament();
        try {
            $this->initPreFlopAction();
            $this->initCards();
        } catch (\Exception $e) {

        }
    }

    private function initTournament(): void
    {
        $this->tournament = new Tournament();
        $this->tournament->setId(substr(explode(' ', $this->rawHandData[1])[5], 1, -1));
        $this->tournament->setNumberOfPlayers(substr(explode(' ', $this->rawHandData[2])[3], 0, 1));

    }

    private function initPreFlopAction(): void
    {
        $keyStart = array_search("*** CARTES FERMÉES ***\n", $this->rawHandData);
        if (preg_match('/\[(\w+)]/i', $this->rawHandData[$keyStart + 1]) === 1) {
            throw new \Exception('main non jouée');
        }
        $this->setCurrentPlayer($this->rawHandData[$keyStart + 1]);
        $matches = preg_grep('/\*{3} FLOP \*{3} \[(\w+)/i', $this->rawHandData);
        if (empty($matches)) {
            $keyEnd = array_search("*** SYNTHÈSE ***\n", $this->rawHandData);
        } else {
            $keyEnd = key($matches);
        }

        $actions = [];
        for ($i = $keyStart + 1; $i < $keyEnd; $i++) {
            $this->preFlopAction[] = $this->rawHandData[$i];
            $this->setIsHandRaisedByPlayerPreFlop($this->rawHandData[$i]);
            $actions[] = $this->rawHandData[$i];
        }

        array_shift($actions);
        if($this->isHandRaisedByPlayerPreFlop) {
            for  ($y = 0; $y < count($actions); $y++) {
                if(preg_match('/'.$this->currentPlayer . '/', $actions[$y])) {
                    $this->position = Position::getPosition($this->tournament->getNumberOfPlayers(), $y);
                    break;
                }
            }
        }
    }

    private function setCurrentPlayer($lineWithPlayer):void
    {
        $this->currentPlayer = explode(' ', $lineWithPlayer)[1];
    }

    private function initCards(): void
    {
        $working = explode(' ', $this->preFlopAction[0]);
        $working = substr($working[2] . ' ' .$working[3], 1, -2);
        $cards = explode(' ', $working);
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

    private function setIsHandRaisedByPlayerPreFlop($action): void
    {
        if (preg_match('/'.$this->currentPlayer .' : relance./', $action) === 1) {
            $this->isHandRaisedByPlayerPreFlop = true;
        }
    }

    public function isHandRaisedByPlayerPreFlop(): bool
    {
        return $this->isHandRaisedByPlayerPreFlop;
    }

    public function getTournament(): Tournament
    {
        return $this->tournament;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function getCards(): string
    {
        return $this->cards;
    }

    public function areCardsSuited(): bool
    {
        return $this->areCardsSuited;
    }

}