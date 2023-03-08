<?php

namespace App\Domain\HandsFile;

class HandsRawFile
{
    protected array $rawContent;

    protected array $rawHands;

    public function __construct(array $rawContent)
    {
        $this->rawContent = $rawContent;
        $this->initRawHands();
    }

    public function getRawHands(): array
    {
        return $this->rawHands;
    }

    private function initRawHands(): void
    {
        $rawHands = [];
        $workingContent = $this->rawContent;
        $currentHandCount = 0;
        foreach ($workingContent as $index => $line) {
            if ($line === "\n") {
                unset($workingContent[$index +1]);
                $currentHandCount++;
                continue;
            }
            $rawHands[$currentHandCount][] = $line;
        }
        $this->rawHands = $rawHands;
    }

}