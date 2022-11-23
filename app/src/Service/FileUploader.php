<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\IEntity;
use App\Entity\Photo;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private $targetDirectory;
    private $slugger;

    public function __construct($targetDirectory, SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
    }

    public function getDirecory(): string
    {
        return $this->targetDirectory;
    }

    public function getName(UploadedFile $file): string
    {
        return pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    }

    public function getExtension(UploadedFile $file): string
    {
        return $file->guessExtension();
    }

    public function upload(UploadedFile $file, Photo $photo)
    {
        $fileName = $photo->getId().'.'.$file->guessExtension();

        $file->move($photo->getFolder(), $fileName);

        return $fileName;
    }
}
