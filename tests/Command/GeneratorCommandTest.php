<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Tests\Command;

use KejawenLab\Semart\Surat\Command\GeneratorCommand;
use KejawenLab\Semart\Surat\Generator\GeneratorFactory;
use KejawenLab\Semart\Surat\Tests\Generator\Stub;
use KejawenLab\Semart\Surat\Tests\TestCase\DatabaseTestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class GeneratorCommandTest extends DatabaseTestCase
{
    public function testRunCommand()
    {
        static::$application->add(new GeneratorCommand($this->getMockBuilder(GeneratorFactory::class)->disableOriginalConstructor()->getMock()));

        $command = static::$application->find('semart:generate');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            'entity' => Stub::class,
        ]);

        $output = $commandTester->getDisplay();
        $this->assertContains(sprintf('Simple CRUD for %s class is generated', Stub::class), $output);
    }
}
