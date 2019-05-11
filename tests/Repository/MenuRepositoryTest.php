<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Tests\Repository;

use KejawenLab\Semart\Surat\Entity\Menu;
use KejawenLab\Semart\Surat\Repository\MenuRepository;
use KejawenLab\Semart\Surat\Repository\Repository;
use KejawenLab\Semart\Surat\Tests\TestCase\DatabaseTestCase;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class MenuRepositoryTest extends DatabaseTestCase
{
    public function testRepository()
    {
        static::bootKernel();

        $repository = new MenuRepository(static::$container->get('doctrine'));

        $this->assertInstanceOf(Repository::class, $repository);

        /** @var Menu $menu */
        $menu = $repository->findByCode('SETTING');

        $this->assertEquals('SETTING', $menu->getCode());
        $this->assertNull($repository->findByCode(static::NOT_FOUND));
    }
}
