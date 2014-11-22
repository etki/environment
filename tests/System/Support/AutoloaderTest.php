<?php

namespace Etki\Environment\Tests\System\Support;

use Etki\Environment\Support\Autoloader;
use org\bovigo\vfs\vfsStream;

/**
 * Tests that autoloader really does it's autoloading functions.
 *
 * @ runTestsInSeparateProcesses
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\Tests\System\Support
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
            'TestClassB.php' => '<?php namespace TestNs; class TestClassB {}',
        ),
    );
    /**
     * List of autoloaders.
     *
     * @type callable[]
     * @since 0.1.0
     */
    protected $loaders = array();
    /**
     * FQCN of the tested class.
     *
     * @type string
     * @since 0.1.0
     */
    const TESTED_CLASS = 'Etki\Environment\Support\Autoloader';

    /**
     * Detaches currently installed autoloaders.
     *
     * @return void
     * @since 0.1.0
     */
    protected function detachAutoloaders()
    {
        $loaders = spl_autoload_functions();
        if (!$loaders) {
            return;
        }
        foreach ($loaders as $loader) {
            spl_autoload_unregister($loader);
            $this->loaders[] = $loader;
        }
    }

    /**
     * Attaches detached autoloaders.
     *
     * @return void
     * @since 0.1.0
     */
    protected function reattachAutoloaders()
    {
        if (!$this->loaders) {
            return;
        }
        foreach ($this->loaders as $loader) {
            spl_autoload_register($loader);
        }
    }

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
        // autoloading the class before unloading the autoloaders.
        class_exists(self::TESTED_CLASS, true);
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
     * Tests that autoloader integrates into SPL autoloader stack properly.
     *
     * @return void
     * @since 0.1.0
     */
    public function testRegistration()
    {
        $autoloader = new Autoloader;
        $callable = array($autoloader, 'loadClass');
        $this->assertFalse(in_array($callable, spl_autoload_functions()));
        $autoloader->register();
        $this->assertTrue(in_array($callable, spl_autoload_functions()));
        $autoloader->unregister();
        $this->assertFalse(in_array($callable, spl_autoload_functions()));
    }


    /**
     * Tests autoloading.
     *
     * @depends testRegistration
     *
     * @return void
     * @since 0.1.0
     */
    public function testAutoloading()
    {
        $autoloaderClassName = self::TESTED_CLASS;
        $className = 'TestNs\\TestClassB';
        $this->assertFalse(class_exists($className, false));
        $this->detachAutoloaders();
        /** @type Autoloader $autoloader */
        $autoloader = new $autoloaderClassName;
        $autoloader->add('TestNs', vfsStream::url('vfs/src'));
        $autoloader->register();
        $classExists = class_exists($className, true);
        $autoloader->unregister();
        $this->reattachAutoloaders();
        $this->assertTrue($classExists);
    }
}
