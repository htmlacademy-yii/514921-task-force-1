<?php


namespace TaskForce;

use yii\web\UploadedFile;

class LocalUploadedFile extends UploadedFile
{
    private $localName;

    public function getName(): string
    {
        if (!$this->localName) {
            $this->localName = md5_file($this->tempName) . '-' . $this->baseName . '.' . $this->extension;
            return $this->localName;
        }
        return $this->localName;
    }
}