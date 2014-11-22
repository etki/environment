<?php

namespace Etki\Environment\Tests\Unit\Support;

use Etki\Environment\Support\Autoloader;
use org\bovigo\vfs\vfsStream;

/**
 * Tests autoloader.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\Tests\Unit\Support
 * @author  Etki <etki@etki.name>
 */
class AutoloaderTest extends \Codeception\TestCase\Test
{
    /**
     * Virtual filesystem structure.
     *
     * @type array
     * @since 0.1.0
     */
    protected $structure = array(
        'src' => array(
            'TestClassA.php' => '<?php namespace TestNs; class TestClassA {}',
        ),
    );

    /**
     * Before-test setup method.
     *
     * @return void
     * @since 0.1.0
     */
    protected function _before()
    {
        vfsStream::setup('vfs');
        vfsStream::create($this->structure);
    }

    /**
     * After-test cleanup method.
     *
     * @return void
     * @since 0.1.0
     */
    protected function _after()
    {
        vfsStream::setup('vfs');
    }

    // tests
    /**
     * Tests that autoloader finds specified class.
     *
     * @return void
     * @since 0.1.0
     */
    public function testAutoloading()
    {
        $autoloader = new Autoloader;
        $autoloader->add('TestNs', vfsStream::url('vfs/src'));
        $className = 'TestNs\TestClassA';
        $this->assertFalse(class_exists($className, false));
        $autoloader->loadClass($className);
        $this->assertTrue(class_exists($className, false));
    }
}
