<?php


namespace App\Utils;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadHelper
{
    private string $saveDir;
    private ImageHelper $imageHelper;

    public function __construct(string $saveDir,ImageHelper $imageHelper)
    {
        $this->saveDir = $saveDir;
        $this->imageHelper = $imageHelper;
        if (!is_dir($saveDir)) {
            @mkdir($saveDir, 0777, true);
        }
    }

    public function save(UploadedFile $file)
    {
        $file->move($this->saveDir,$file->getClientOriginalName());
        return $this->imageHelper->getHost() . '/uploads/files/products/' . $file->getClientOriginalName();
    }

}