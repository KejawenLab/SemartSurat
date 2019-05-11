<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Tests\Repository;

use KejawenLab\Semart\Surat\Entity\User;
use KejawenLab\Semart\Surat\Repository\Repository;
use KejawenLab\Semart\Surat\Repository\UserRepository;
use KejawenLab\Semart\Surat\Tests\TestCase\DatabaseTestCase;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class UserRepositoryTest extends DatabaseTestCase
{
    public function testRepository()
    {
        static::bootKernel();

        $repository = new UserRepository(static::$container->get('doctrine'));

        $this->assertInstanceOf(Repository::class, $repository);

        /** @var User $user */
        $user = $repository->findOneBy(['username' => 'admin']);

        $this->assertEquals('admin', $user->getUsername());
        $this->assertNull($repository->findOneBy(['username' => static::NOT_FOUND]));
    }
}
