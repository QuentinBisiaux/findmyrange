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

    private int $numberOfRaise = 0;

    private bool $isHandFoldedByHeroPreFlop = false;

    private bool $isHandRaisedByHeroPreFlop = false;

    private bool $isHand3BetByHeroPreFlop = false;

    private bool $isHand4BetByHeroPreFlop = false;

    private bool $isHandLimpedByHeroPreFlop = false;

    public function __construct(array $rawHandData)
    {
        $this->rawHandData = $rawHandData;
        $this->initPreFlopAction();
        $this->card = new Card($this->preFlopAction[0]);
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
        if(preg_match('/\[[a-z2-9]{2} [a-z2-9]{2}]/i', $this->rawHandData[$keyStart + 1]) == 0) {
            throw new \Exception("Pas de cartes reçues \n");
        }
        if (preg_match('/\[(\w+)]/i', $this->rawHandData[$keyStart + 1]) === 1) {
            throw new \Exception('Main non jouée \n');
        }
        $this->setCurrentPlayer($this->rawHandData[$keyStart + 1]);
        $matches = preg_grep("/\*{3} FLOP \*{3} \[(\w+)/i", $this->rawHandData);
        if (empty($matches)) {
            $keyEnd = array_search("*** SYNTHÈSE ***\n", $this->rawHandData);
        } else {
            $keyEnd = key($matches);
        }

        $actions = [];
        for ($i = $keyStart + 1; $i < $keyEnd; $i++) {
            $this->preFlopAction[] = $this->rawHandData[$i];
            $this->setIsHandFoldedByHeroPreFlop($this->rawHandData[$i]);
            $this->setIsHandRaisedPreFlop($this->rawHandData[$i]);
            $this->setIsHandLimpedByHeroPreFlop($this->rawHandData[$i]);
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
        if($this->isHandRaisedByHeroPreFlop) {
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

    private function setIsHandFoldedByHeroPreFlop($action) {
        if (preg_match('/'.$this->currentPlayer .' : passe./', $action) === 1) {
            $this->isHandFoldedByHeroPreFlop = true;
        }
    }

    private function setIsHandRaisedPreFlop($action): void
    {
        if (preg_match('/'.$this->currentPlayer .' : relance./', $action) === 1) {
            if($this->numberOfRaise === 0) {
                $this->isHandRaisedByHeroPreFlop = true;
            } elseif($this->numberOfRaise === 1) {
                $this->isHand3BetByHeroPreFlop = true;
            } elseif($this->numberOfRaise === 2) {
                $this->isHand4BetByHeroPreFlop = true;
            }
        }
        if (preg_match('/ : relance./', $action) === 1) {
            $this->numberOfRaise++;
        }
    }
    private function setIsHandLimpedByHeroPreFlop($action): void
    {
        if (
            preg_match('/'.$this->currentPlayer .' : suit./', $action) === 1
            and
            $this->numberOfRaise === 0
        ) {
            $this->isHandLimpedByHeroPreFlop = true;
        }
    }

    public function isHandRaisedByHeroPreFlop(): bool
    {
        return $this->isHandRaisedByHeroPreFlop;
    }

    public function isHand3BetByHeroPreFlop(): bool
    {
        return $this->isHand3BetByHeroPreFlop;
    }

    public function isHand4BetByHeroPreFlop(): bool
    {
        return $this->isHand4BetByHeroPreFlop;
    }

    public function isHandLimpedByHeroPreFlop(): bool
    {
        return $this->isHandLimpedByHeroPreFlop;
    }

    public function isHandFoldedByHeroPreFlop(): bool
    {
        return $this->isHandFoldedByHeroPreFlop;
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