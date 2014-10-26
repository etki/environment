<?php

namespace Variables;

use Etki\Environment\Variables\VariableManager;
use Etki\Environment\Variables\VariableStorage;

class VariableStorageTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    protected $testedClass = 'Etki\Environment\Variables\VariableStorage';

    /**
     *
     *
     * @param null $storage
     *
     * @return VariableStorage
     * @since 0.1.0
     */
    protected function getInstance(&$storage = null)
    {
        if (!is_array($storage)) {
            $storage = array();
        }
        return new $this->testedClass($storage);
    }
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

        $manager = new VariableManager; // testing program with itself
                                        // it will be fun if it fails
        $snapshot = $manager->snapshot();

        $key = md5(time());
        if (isset($_SERVER[$key])) {
            unset($_SERVER[$key]);
        }
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

        $manager->restore($snapshot);
    }
}
