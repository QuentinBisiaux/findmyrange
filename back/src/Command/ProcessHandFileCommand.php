<?php

namespace App\Command;

use App\Domain\Hand\Hand;
use App\Domain\Hand\HandCollection;
use App\Domain\HandsFile\HandsRawFile;
use App\Infrastructure\FileManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[AsCommand(
    name: 'process-hands',
    description: 'process all hands of a txt file',
)]
class ProcessHandFileCommand extends Command
{

    public function __construct(private FileManager $fileManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        try {
            $fileContent = $this->fileManager->getFileContent(__DIR__ . '/../../var/data/hands');
        } catch (FileException $ex) {
            $io->error($ex->getMessage());
        }
        if (empty($fileContent)) {
            $io->error('No data to process');
            return Command::FAILURE;
        }
        $handRawFile = new HandsRawFile($fileContent);
        $rawHands = $handRawFile->getRawHands();

        $handCollection = new HandCollection();
        foreach($rawHands as $rawHand) {
            $hand = new Hand($rawHand);
            $handCollection->addHand($hand);
        }
        dump($handCollection->getCardsRaisedPreFlop());

        return self::SUCCESS;
    }

}