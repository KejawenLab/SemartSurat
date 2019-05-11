<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Tests\Request;

use KejawenLab\Semart\Surat\Application;
use KejawenLab\Semart\Surat\Entity\Group;
use KejawenLab\Semart\Surat\Request\RequestHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class RequestHandlerTest extends TestCase
{
    public function testHandler()
    {
        $validatorMock = $this->getMockBuilder(ValidatorInterface::class)->disableOriginalConstructor()->getMock();
        $validatorMock
            ->expects($this->once())
            ->method('validate')
            ->withAnyParameters()
            ->willReturn([])
        ;

        $eventDispatcherMock = $this->getMockBuilder(EventDispatcherInterface::class)->disableOriginalConstructor()->getMock();

        $translatorMock = $this->getMockBuilder(TranslatorInterface::class)->disableOriginalConstructor()->getMock();

        $requestHandler = new RequestHandler(new Application(), $validatorMock, $eventDispatcherMock, $translatorMock);

        $request = Request::createFromGlobals();
        $request->request->set('code', 'XXX');
        $request->request->set('name', 'TEST');

        $group = new Group();

        $requestHandler->handle($request, $group);

        $this->assertEquals('XXX', $group->getCode());
        $this->assertEquals('TEST', $group->getName());

        $this->assertEmpty($requestHandler->getErrors());
        $this->assertTrue($requestHandler->isValid());
    }
}
