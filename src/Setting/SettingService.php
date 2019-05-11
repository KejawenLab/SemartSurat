<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Setting;

use KejawenLab\Semart\Surat\Contract\Service\ServiceInterface;
use KejawenLab\Semart\Surat\Entity\Setting;
use KejawenLab\Semart\Surat\Repository\SettingRepository;
use PHLAK\Twine\Str;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class SettingService implements ServiceInterface
{
    private $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $settingRepository->setCacheable(true);
        $this->settingRepository = $settingRepository;
    }

    /**
     * @param string $parameter
     *
     * @return string|int|float|null
     */
    public function getValue(string $parameter)
    {
        if ($setting = $this->settingRepository->findOneBy(['parameter' => Str::make($parameter)->uppercase()])) {
            return $setting->getValue();
        }

        return null;
    }

    /**
     * @param string $id
     *
     * @return Setting|null
     */
    public function get(string $id): ?object
    {
        return $this->settingRepository->find($id);
    }
}
