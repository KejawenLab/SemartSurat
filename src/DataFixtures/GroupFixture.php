<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\DataFixtures;

use KejawenLab\Semart\Surat\Entity\Group;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class GroupFixture extends Fixture
{
    protected function createNew()
    {
        return new Group();
    }

    protected function getReferenceKey(): string
    {
        return 'group';
    }
}
