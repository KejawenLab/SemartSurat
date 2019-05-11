<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Tests\Entity;

use KejawenLab\Semart\Surat\Entity\Setting;
use PHPUnit\Framework\TestCase;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class SettingTest extends TestCase
{
    public function testObject()
    {
        $this->assertEquals(Setting::class, \get_class(new Setting()));
    }
}
