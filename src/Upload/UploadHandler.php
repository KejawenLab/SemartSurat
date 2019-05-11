<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Upload;

use KejawenLab\Semart\Surat\Application;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class UploadHandler
{
    private $fileLocator;

    public function __construct(FileUploadLocator $fileLocator)
    {
        $this->fileLocator = $fileLocator;
    }

    public function handle(UploadedFile $uploadedFile)
    {
        $fileName = sprintf('%s.%s', $this->fileLocator->createUniqueFileName(), $uploadedFile->guessExtension() ?: Application::APP_UNIQUE_NAME);
        $uploadDir = $this->fileLocator->getUploadDir();

        $fileSystem = new Filesystem();
        if (!$fileSystem->exists($uploadDir)) {
            $fileSystem->mkdir($uploadDir);
        }

        $uploadedFile->move($uploadDir, $fileName);

        return $fileName;
    }
}
