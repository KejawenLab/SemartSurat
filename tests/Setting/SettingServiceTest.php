<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Tests\Setting;

use KejawenLab\Semart\Surat\Entity\Setting;
use KejawenLab\Semart\Surat\Repository\SettingRepository;
use KejawenLab\Semart\Surat\Setting\SettingService;
use PHPUnit\Framework\TestCase;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class SettingServiceTest extends TestCase
{
    const NOT_EXIST = 'NOT_EXIST';

    public function testGetSettingValue()
    {
        $setting = new Setting();
        $setting->setParameter('PER_PAGE');
        $setting->setValue(17);

        $repositoryMock = $this->getMockBuilder(SettingRepository::class)->disableOriginalConstructor()->getMock();
        $repositoryMock
            ->method('findOneBy')
            ->with(
                $this->logicalOr(
                    ['parameter' => $setting->getParameter()],
                    ['parameter' => static::NOT_EXIST]
                )
            )
            ->willReturnCallback(
                function (array $parameter) use ($setting) {
                    if (static::NOT_EXIST === $parameter['parameter']->__toString()) {
                        return null;
                    }

                    return $setting;
                }
            )
        ;

        $settingService = new SettingService($repositoryMock);

        $this->assertEquals($setting->getValue(), $settingService->getValue($setting->getParameter()));
        $this->assertNull($settingService->getValue(static::NOT_EXIST));
    }
}
