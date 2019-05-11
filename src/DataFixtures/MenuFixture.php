<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\DataFixtures;

use KejawenLab\Semart\Surat\Entity\Menu;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class MenuFixture extends Fixture
{
    protected function createNew()
    {
        return new Menu();
    }

    protected function getReferenceKey(): string
    {
        return 'menu';
    }
}
