<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Tests\Security\Service;

use KejawenLab\Semart\Surat\Entity\User;
use KejawenLab\Semart\Surat\Repository\UserRepository;
use KejawenLab\Semart\Surat\Security\Service\UserService;
use PHPUnit\Framework\TestCase;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class UserServiceTest extends TestCase
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var UserService
     */
    private $userProviderService;

    public function setUp()
    {
        $this->user = new User();
        $this->user->setUsername('test');

        $userRepositoryMock = $this->getMockBuilder(UserRepository::class)->disableOriginalConstructor()->getMock();
        $userRepositoryMock
            ->method('findOneBy')
            ->with(['username' => $this->user->getUsername()])
            ->willReturn($this->user)
        ;

        $this->userProviderService = new UserService($userRepositoryMock);
    }

    public function testProvider()
    {
        $this->assertEquals($this->user->getUsername(), $this->userProviderService->loadUserByUsername($this->user->getUsername())->getUsername());
        $this->assertEquals($this->user->getUsername(), $this->userProviderService->refreshUser($this->user)->getUsername());
        $this->assertTrue($this->userProviderService->supportsClass(User::class));
    }
}
