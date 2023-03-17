<?php

namespace App\Tests\Domain\Card;

use App\Domain\Card\Card;
use PHPUnit\Framework\TestCase;

class CardTest extends TestCase
{

    public function testInitRawHandData(): void
    {
        $rawHandLine = "Distribuées RayuRuna [Qc Ac]\n";
        $card = new Card($rawHandLine);
        $this->assertEquals($rawHandLine, $card->getRawCardsData());
    }

    public function testAreCardsSuited(): void
    {
        $suitedCards = new Card("Distribuées RayuRuna [Qc Ac]\n");
        $noSuitedCards = new Card("Distribuées RayuRuna [Qc Ah]\n");
        $this->assertEquals(true, $suitedCards->areCardsSuited());
        $this->assertEquals(false, $noSuitedCards->areCardsSuited());
    }

    public function testGetCards(): void
    {
            $card = new Card("Distribuées RayuRuna [Qc Ac]\n");
            $cardNotSuited = new Card("Distribuées RayuRuna [Qc Ad]\n");
            $this->assertEquals('AQs', $card->getCards());
            $this->assertEquals('AQ', $cardNotSuited->getCards());
    }
}
