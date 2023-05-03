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
        $files = $this->fileManager->getAllFiles(__DIR__ . '/../../var/data', '*.txt');

        if(!$files->hasResults()) {
            $io->error('No files to process');
            return Command::FAILURE;
        }
        $handCollection = new HandCollection();
        foreach ($files as $file) {
            try {
                $fileContent = $this->fileManager->getFileContent($file->getPath() . '/' . $file->getFilename());
            } catch (FileException $ex) {
                $io->error($ex->getMessage());
            }
            if (empty($fileContent)) {
                $io->error('No data to process in file ' . $file->getRelativePathname());
                return Command::FAILURE;
            }
            $handRawFile = new HandsRawFile($fileContent);
            $rawHands = $handRawFile->getRawHands();

            foreach($rawHands as $rawHand) {
                try {
                    $hand = new Hand($rawHand);
                    $handCollection->addHand($hand);
                }catch (\Exception $e) {
                    $io->info($e->getMessage());
                }

            }
        }
        $handCollection->setMatrix();
        $handCollection->setCardsRaisedPreFlop();
        dump(json_encode($handCollection->getMatrix()));

        return self::SUCCESS;
    }

}