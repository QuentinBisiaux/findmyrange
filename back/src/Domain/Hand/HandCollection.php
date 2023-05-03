<?php

namespace App\Domain\Hand;

class HandCollection
{
    /** @var Hand[] */
    private array $collection = [];

//    private array $cardsRaisedPreFlop = [];

    private array $matrix;

    public function addHand(Hand $hand): void
    {
        $this->collection[] = $hand;
    }

    public function getHandCount(): int
    {
        return count($this->collection);
    }

    public function setCardsRaisedPreFlop(): void
    {
        $data = [];
        $data['condensed'] = [];
        $raised = 0;
        foreach ($this->collection as $hand) {
            $cards = $hand->getCards()->getCards();
            $this->matrix['hands'][$cards]['played']++;
            $numberOfPlayers = $hand->getTournament()->getNumberOfPlayers();
            if(!array_key_exists($numberOfPlayers, $data)) $data[$numberOfPlayers] = [];

            if($hand->isHandFoldedByHeroPreFlop()) {
                $this->matrix['sum']['folded']++;
                $this->matrix['hands'][$cards]['folded']++;
            }

            if($hand->isHandRaisedByHeroPreFlop()) {
                $this->matrix['sum']['raised']++;
                $this->matrix['hands'][$cards]['raised']++;
            }

            if($hand->isHand3BetByHeroPreFlop()) {
                $this->matrix['sum']['3Bet']++;
                $this->matrix['hands'][$cards]['3Bet']++;
            }

            if($hand->isHand4BetByHeroPreFlop()) {
                $this->matrix['sum']['4Bet']++;
                $this->matrix['hands'][$cards]['4Bet']++;
            }

            if($hand->isHandLimpedByHeroPreFlop()) {
                $this->matrix['sum']['limped']++;
                $this->matrix['hands'][$cards]['limped']++;
            }

            $raised++;

            if(!array_key_exists($cards, $data['condensed'])) {
                $data['condensed'][$cards] = 1;
            } else {
                $data['condensed'][$cards]++;
            }

//            $position = $hand->getPosition();

/*            if(!array_key_exists($position, $data[$numberOfPlayers])) $data[$numberOfPlayers][$position] = [];
            if(!array_key_exists($cards, $data[$numberOfPlayers][$position])) {
                $data[$numberOfPlayers][$position][$cards] = 1;
            } else {
                $data[$numberOfPlayers][$position][$cards]++;
            }*/
        }
        $data['all'] = $this->getHandCount();
        $data['allRaised'] = $raised;
        $this->matrix['sum']['played'] = $this->getHandCount();
//        $this->cardsRaisedPreFlop = $data;
    }

    /**
     * @return array
     */
    public function getMatrix(): array
    {
        return $this->matrix;
    }

    public function setMatrix(): void
    {
        $this->matrix = HandMatrix::initHandMatrix();
    }



}