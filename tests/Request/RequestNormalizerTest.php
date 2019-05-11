<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Tests\Request;

use KejawenLab\Semart\Surat\Request\RequestNormalizer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class RequestNormalizerTest extends KernelTestCase
{
    public function testNormalize()
    {
        static::bootKernel();

        $request = Request::createFromGlobals();
        $request->request->set('a', 'true');
        $request->request->set('b', 'false');

        $event = new GetResponseEvent(static::$kernel, $request, HttpKernelInterface::MASTER_REQUEST);

        $requestNormalizer = new RequestNormalizer();
        $requestNormalizer->normalize($event);

        $this->assertTrue($request->request->get('a'));
        $this->assertFalse($request->request->get('b'));
    }

    public function testGetSubscribedEvents()
    {
        $this->assertCount(1, RequestNormalizer::getSubscribedEvents());
    }
}
