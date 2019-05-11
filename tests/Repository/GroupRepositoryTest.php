<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Tests\Repository;

use KejawenLab\Semart\Surat\Entity\Group;
use KejawenLab\Semart\Surat\Repository\GroupRepository;
use KejawenLab\Semart\Surat\Repository\Repository;
use KejawenLab\Semart\Surat\Tests\TestCase\DatabaseTestCase;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class GroupRepositoryTest extends DatabaseTestCase
{
    public function testRepository()
    {
        static::bootKernel();

        $repository = new GroupRepository(static::$container->get('doctrine'));

        $this->assertInstanceOf(Repository::class, $repository);

        /** @var Group $group */
        $group = $repository->findOneBy(['code' => 'SPRADM']);

        $this->assertEquals('SPRADM', $group->getCode());
        $this->assertNull($repository->findOneBy(['code' => static::NOT_FOUND]));
    }
}
