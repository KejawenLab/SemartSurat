<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Tests\Entity;

use KejawenLab\Semart\Surat\Entity\Menu;
use PHPUnit\Framework\TestCase;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class MenuTest extends TestCase
{
    public function testObject()
    {
        $this->assertEquals(Menu::class, \get_class(new Menu()));
    }
}
