<?php

declare(strict_types=1);
/**
 * This file is part of the Ray.Di package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ray\Di;

use PHPUnit\Framework\TestCase;
use Ray\Compiler\DiCompiler;

class DiCompilerTest extends TestCase
{
    public function testUntargetInject()
    {
        /* @var $fake FakeUntarget */
        $module = new FakeUntargetModule;
        $compiler = new DiCompiler($module, $_ENV['TMP_DIR']);
        $compiler->compile();
        $fake = $compiler->getInstance(FakeUntarget::class);
        $this->assertSame(1, $fake->child->val);
    }
}
