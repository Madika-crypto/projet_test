<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploadService
{
    private $slugger;

    private $uploadFolder = "images/uploads/";

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function upload(UploadedFile $newFile, ?string $oldFile =""): string
    {
            $originalFileName = pathinfo($newFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFileName);
            $fullFilename = $safeFilename . uniqid() . '.' . $newFile->guessExtension();
            // $newFile->move("images/uploads", $fullFilename);
            $newFile->move($this->uploadFolder, $fullFilename);
            $this->delete($oldFile);
            return $fullFilename;
    }

    public function delete(?string $oldFileName =""): void
    {
        if ($oldFileName) {
            unlink($this->uploadFolder . $oldFileName);
        }     
    }
}