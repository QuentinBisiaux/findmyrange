<?php

namespace App\Infrastructure;

use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileManager
{
    private Finder $finder;

    public function __construct()
    {
        $this->finder = new Finder();
    }

    public function getAllFiles(string $path, string $ext = ''): Finder
    {
       return $this->finder->files()->in($path)->name($ext);
    }

    public function getFileContent(string $path): array
    {
        if (!is_file($path)) throw new FileException('There is no file at : ' . $path);
        return file($path);
    }

}