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
        foreach ($workingContent as $line) {
            if ($line === "\n") {
                continue;
            }
            if(preg_match('/\*{10} # [0-9]* \*{10}/', $line) === 1) {
                $currentHandCount++;
            }
            if($currentHandCount === 0 and preg_match('/\*{10} # [0-9]* \*{10}/', $line) !== 1) {
                continue;
            }
            $rawHands[$currentHandCount][] = $line;
        }
        $this->rawHands = $rawHands;
    }

}