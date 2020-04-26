<?php


namespace TaskForce\services;

use yii\web\UploadedFile;

class FileService extends UploadedFile
{
    private $localName;

    public function getName()
    {
        if (!$this->localName) {
            $this->localName = md5_file($this->tempName) . '-' . $this->baseName . '.' . $this->extension;
            return $this->localName;
        }
        return $this->localName;
    }
}