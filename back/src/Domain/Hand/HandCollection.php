<?php

namespace App\Domain\Hand;

class HandCollection
{
    /** @var Hand[] */
    private array $collection = [];

    public function addHand(Hand $hand): void
    {
        $this->collection[] = $hand;
    }

    public function getHandCount(): int
    {
        return count($this->collection);
    }

    public function getCardsRaisedPreFlop(): array
    {
        $data = [];
        $raised = 0;
        foreach ($this->collection as $hand) {

            $numberOfPlayers = $hand->getTournament()->getNumberOfPlayers();
            if(!array_key_exists($numberOfPlayers, $data)) $data[$numberOfPlayers] = [];

            if(!$hand->isHandRaisedByPlayerPreFlop()) continue;

            $raised++;
            $index = $hand->getCards()->getCards();
            $position = $hand->getPosition();
            if(!array_key_exists($position, $data[$numberOfPlayers])) $data[$numberOfPlayers][$position] = [];
            if(!array_key_exists($index, $data[$numberOfPlayers][$position])) {
                $data[$numberOfPlayers][$position][$index] = 1;
            } else {
                $data[$numberOfPlayers][$position][$index]++;
            }
        }
        $data['all'] = $this->getHandCount();
        $data['allRaised'] = $raised;
        ksort($data, SORT_STRING);
        return $data;
    }


}