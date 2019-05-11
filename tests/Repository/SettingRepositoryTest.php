<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Tests\Repository;

use KejawenLab\Semart\Surat\Entity\Setting;
use KejawenLab\Semart\Surat\Pagination\Paginator;
use KejawenLab\Semart\Surat\Repository\Repository;
use KejawenLab\Semart\Surat\Repository\SettingRepository;
use KejawenLab\Semart\Surat\Tests\TestCase\DatabaseTestCase;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class SettingRepositoryTest extends DatabaseTestCase
{
    public function testRepository()
    {
        static::bootKernel();

        $repository = new SettingRepository(static::$container->get('doctrine'));

        $this->assertInstanceOf(Repository::class, $repository);

        /** @var Setting $setting */
        $setting = $repository->findOneBy(['parameter' => 'PER_PAGE']);

        $this->assertEquals(Paginator::PER_PAGE, $setting->getValue());
        $this->assertNull($repository->findOneBy(['parameter' => static::NOT_FOUND]));
    }
}
