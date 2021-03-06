<?php

declare(strict_types=1);
/**
 * This file is part of the Ray.Di package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\Di;

use PHPUnit\Framework\TestCase;
use Ray\Di\Exception\NotFound;

class ModuleTest extends TestCase
{
    public function testNew()
    {
        $module = new FakeInstanceBindModule;
        $this->assertInstanceOf(AbstractModule::class, $module);
    }

    public function testInstall()
    {
        $module = new FakeInstallModule;
        $this->assertInstanceOf(AbstractModule::class, $module);
    }

    public function testToInvalidClass()
    {
        $this->expectException(NotFound::class);
        new FakeToBindInvalidClassModule;
    }

    public function testRename()
    {
        $module = new FakeRenameModule(new FakeToBindModule);
        $instance = $module->getContainer()->getInstance(FakeRobotInterface::class, 'original');
        $this->assertInstanceOf(FakeRobotInterface::class, $instance);
    }

    public function testConstructorCallModule()
    {
        $module = new FakelNoConstructorCallModule;
        $container = $module->getContainer();
        $this->assertInstanceOf(Container::class, $container);
    }

    public function testActivate()
    {
        $module = new FakeInstanceBindModule;
        $this->assertInstanceOf(Container::class, $module->getContainer());
    }
}
