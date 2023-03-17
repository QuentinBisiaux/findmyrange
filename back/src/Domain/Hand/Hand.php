<?php

namespace App\Domain\Hand;

use App\Domain\Card\Card;
use App\Domain\Position\Position;
use App\Domain\Tournament\Tournament;

class Hand
{
    private array $rawHandData = [];

    private string $currentPlayer;

    private Tournament $tournament;

    private string $position;

    private array $preFlopAction;

    private Card $card;

    private bool $isHandRaisedByPlayerPreFlop = false;

    public function __construct(array $rawHandData)
    {
        $this->rawHandData = $rawHandData;
        try {
            $this->initPreFlopAction();
            $this->card = new Card($this->preFlopAction[0]);
        } catch (\Exception $e) {
            echo $e->getMessage();
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
            throw new \Exception('Main non jouée');
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
        if (
            preg_match('/Main PokerStars n°/i', $this->rawHandData[1]) !== 1
            or
            preg_match('/-max Siège #/i', $this->rawHandData[2]) !== 1
        ) {
            throw new \Exception($this->rawHandData[1] . " \nPas un tournoi\n");
        }
        $this->initTournament();

        array_shift($actions);
        if($this->isHandRaisedByPlayerPreFlop) {
            $unlessLines = 0;
            for  ($y = 0; $y < count($actions); $y++) {
                if(
                    str_contains($actions[$y], 'a dépassé le temps imparti.')
                    or
                    str_contains($actions[$y], 'ne joue pas.')
                    or
                    str_contains($actions[$y], ' est revenu.')
                ) {
                    $unlessLines++;
                    continue;
                }
                if(preg_match('/'.$this->currentPlayer . '/', $actions[$y])) {
                    $realPosition = $y - $unlessLines;
                    $this->position = Position::getPosition($this->tournament->getNumberOfPlayers(), $realPosition);
                    break;
                }
            }
        }
    }

    private function setCurrentPlayer($lineWithPlayer):void
    {
        $this->currentPlayer = explode(' ', $lineWithPlayer)[1];
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

    public function getCards(): Card
    {
        return $this->card;
    }

}