<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Tests\Entity;

use KejawenLab\Semart\Surat\Entity\Group;
use PHPUnit\Framework\TestCase;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class GroupTest extends TestCase
{
    public function testObject()
    {
        $this->assertEquals(Group::class, \get_class(new Group()));
    }
}
