<?php

namespace Etki\Environment\Tests\Unit\Support;

use Etki\Environment\Support\Autoloader;
use org\bovigo\vfs\vfsStream;
use Codeception\TestCase\Test;

/**
 * Tests autoloader.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\Tests\Unit\Support
 * @author  Etki <etki@etki.name>
 */
class AutoloaderTest extends Test
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

    // @codingStandardsIgnoreStart

    /**
     * Before-test setup method.
     *
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
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
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     *
     * @return void
     * @since 0.1.0
     */
    protected function _after()
    {
        vfsStream::setup('vfs');
    }

    // @codingStandardsIgnoreEnd

    // data providers

    /**
     * Provides namespaces to preload, name of the class and path which
     * autoloader should output for that particular FQCN.
     *
     * @return array
     * @since 0.1.0
     */
    public function classNamePathProvider()
    {
        return array(
            array(
                array('TestNamespace' => '/some/path',),
                'TestNamespace\SubSpace\TestClass',
                '/some/path/SubSpace/TestClass.php',
            ),
            array(
                array(),
                'TestNamespace\TestClass',
                false
            )
        );
    }

    // tests

    /**
     * Verifies that class names are resolved to correct paths.
     *
     * @param string[] $namespaces Namespaces to preload in
     *                             [namespace => root dir] format.
     * @param string   $className  Fully-qualified class name.
     * @param string   $path       Expected resolved path.
     *
     * @dataProvider classNamePathProvider
     *
     * @return void
     * @since 0.1.0
     */
    public function testPathResolving(array $namespaces, $className, $path)
    {
        $autoloader = new Autoloader;
        $autoloader->addNamespaces($namespaces);
        $this->assertSame($path, $autoloader->locateClass($className));
    }

    /**
     * Tests that autoloader finds specified class.
     *
     * @return void
     * @since 0.1.0
     */
    public function testAutoloading()
    {
        $autoloader = new Autoloader;
        $autoloader->addNamespace('TestNs', vfsStream::url('vfs/src'));
        $className = 'TestNs\TestClassA';
        $this->assertFalse(class_exists($className, false));
        $this->assertTrue($autoloader->loadClass($className));
        $this->assertTrue(class_exists($className, false));
        $missingClassName = 'Missing\Missing';
        $this->assertFalse($autoloader->loadClass($missingClassName));
        $autoloader->addNamespace('MissingNs', '/bin/who-would-put-here-src');
        $missingFileClassName = 'MissingNs\Missing';
        $this->assertFalse($autoloader->loadClass($missingFileClassName));
    }
}
