<?php

namespace Etki\Environment\Tests\Unit\Variables;

use Etki\Environment\Variables\Storage;
use ArrayAccess;

/**
 * Tests variable storage.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\Tests\Unit\Variables
 * @author  Etki <etki@etki.name>
 */
class StorageTest extends \Codeception\TestCase\Test
{
    /**
     * Tested class FQCN.
     *
     * @type string
     * @since 0.1.0
     */
    const TESTED_CLASS = 'Etki\Environment\Variables\Storage';

    /**
     * Returns new storage instance.
     *
     * @param array|ArrayAccess $storage
     *
     * @return Storage New instance.
     * @since 0.1.0
     */
    protected function getInstance(&$storage = null)
    {
        if (!is_array($storage)) {
            $storage = array();
        }
        $testedClass = self::TESTED_CLASS;
        return new $testedClass($storage);
    }

    /**
     * Boring test.
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     *
     * @return void
     * @since 0.1.0
     */
    public function testStorage()
    {
        $storage = array(1 => 12,);
        $interface = $this->getInstance($storage);
        $this->assertTrue($interface->has(1));
        $this->assertFalse($interface->has(2));
        $interface->set(2, 13);
        $this->assertTrue($interface->has(2));
        $this->assertArrayHasKey(2, $storage);
        $this->assertSame(13, $interface->get(2));
        $this->assertSame(13, $storage[2]);
        $interface->set(2, 14);
        $this->assertSame(14, $interface->get(2));
        $this->assertSame(14, $storage[2]);
        $interface->delete(2);
        $this->assertFalse($interface->has(2));
        $this->assertArrayNotHasKey(2, $storage);

        $key = md5(time());
        unset($_SERVER[$key]);

        $interface = $this->getInstance($_SERVER);
        $this->assertArrayNotHasKey($key, $_SERVER);
        $this->assertFalse($interface->has($key));
        $interface->set($key, 12);
        $this->assertTrue($interface->has($key));
        $this->assertSame(12, $interface->get($key));
        $this->assertArrayHasKey($key, $_SERVER);
        $this->assertSame(12, $_SERVER[$key]);
        $interface->delete($key);
        $this->assertFalse($interface->has($key));
        $this->assertArrayNotHasKey($key, $_SERVER);
        $_SERVER[$key] = 12;
        $this->assertTrue($interface->has($key));
        $this->assertSame(12, $interface->get($key));
        $this->assertSame(sizeof($_SERVER), $interface->getLength());
        $interface->truncate();
        $this->assertEmpty($_SERVER);
        $this->assertSame(0, $interface->getLength());

        unset($_SERVER[$key]);
    }
}
