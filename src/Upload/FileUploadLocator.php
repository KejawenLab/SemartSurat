<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Upload;

use KejawenLab\Semart\Surat\Setting\SettingService;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class FileUploadLocator
{
    private $setting;

    private $kernel;

    public function __construct(SettingService $setting, KernelInterface $kernel)
    {
        $this->setting = $setting;
        $this->kernel = $kernel;
    }

    public function getRealPath(string $file)
    {
        return sprintf('%s/%s', $this->getUploadDir(), $file);
    }

    public function getFile(string $path)
    {
        $fileSystem = new Filesystem();
        if ($fileSystem->exists($path)) {
            return file_get_contents($path);
        }

        throw new FileNotFoundException();
    }

    public function getUploadDir()
    {
        return sprintf('%s/%s', $this->kernel->getProjectDir(), $this->setting->getValue('upload_dir'));
    }

    public function createUniqueFileName()
    {
        return md5(Uuid::getFactory()->uuid4()->toString());
    }
}
