<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\DataFixtures;

use KejawenLab\Semart\Surat\Entity\Setting;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class SettingFixture extends Fixture
{
    protected function createNew()
    {
        return new Setting();
    }

    protected function getReferenceKey(): string
    {
        return 'setting';
    }
}
