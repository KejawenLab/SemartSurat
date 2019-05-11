<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Tests\Entity;

use Doctrine\Common\Persistence\ObjectManager;
use KejawenLab\Semart\Surat\Entity\EntityEvent;
use PHPUnit\Framework\TestCase;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class FilterEntityTest extends TestCase
{
    public function testObject()
    {
        $objectManagerMock = $this->getMockBuilder(ObjectManager::class)->disableOriginalConstructor()->getMock();

        $object = new \stdClass();

        $filterEntity = new EntityEvent($objectManagerMock, $object);

        $this->assertSame($object, $filterEntity->getEntity());
        $this->assertSame($objectManagerMock, $filterEntity->getManager());
    }
}
