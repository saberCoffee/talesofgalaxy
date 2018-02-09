<?php

namespace ToG\ForumBundle;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $file, $oldFile = false)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->targetDir, $fileName);

        if ($oldFile) {
            unlink($this->targetDir . '/' . $oldFile);
        }

        return $fileName;
    }

    public function getTargetDir()
    {
        return $this->targetDir;
    }
}
