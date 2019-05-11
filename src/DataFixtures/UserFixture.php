<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use KejawenLab\Semart\Surat\Entity\User;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class UserFixture extends Fixture implements DependentFixtureInterface
{
    protected function createNew()
    {
        return new User();
    }

    protected function getReferenceKey(): string
    {
        return 'user';
    }

    public function getDependencies()
    {
        return [
            GroupFixture::class,
        ];
    }
}
