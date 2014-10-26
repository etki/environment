<?php

namespace Etki\Environment\Variables;

use ArrayAccess;

/**
 * Simple variable storage wrap that controls underlying level.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\Variables
 * @author  Etki <etki@etki.name>
 */
class VariableStorage
{
    /**
     * Storage itself.
     *
     * @type array|ArrayAccess
     * @since 0.1.0
     */
    protected $storage;

    /**
     * Creates instance.
     *
     * @param array|ArrayAccess $storage Real value storage.
     *
     * @return self
     * @since 0.1.0
     */
    public function __construct(&$storage)
    {
        $this->storage = &$storage;
    }

    /**
     * Saves item.
     *
     * @param string $key   Item identifier.
     * @param mixed  $value Value to save.
     *
     * @return void
     * @since 0.1.0
     */
    public function set($key, $value)
    {
        $this->storage[$key] = $value;
    }

    /**
     * Retrieves key item value.
     *
     * @param string $key Item identifier.
     *
     * @return mixed Item value.
     * @since 0.1.0
     */
    public function get($key)
    {
        return $this->storage[$key];
    }

    /**
     * Tells if key exists in storage.
     *
     * @param string $key Item identifier.
     *
     * @return bool
     * @since 0.1.0
     */
    public function has($key)
    {
        return isset($this->storage[$key]);
    }

    /**
     * Deletes key from storage.
     *
     * @param string $key Identifier of item ro delete.
     *
     * @return void
     * @since 0.1.0
     */
    public function delete($key)
    {
        unset($this->storage[$key]);
    }

    /**
     * Returns number of elements in underlying storage.
     *
     * @return int Storage length.
     * @since 0.1.0
     */
    public function getLength()
    {
        return sizeof($this->storage);
    }

    /**
     * Truncates internal storage.
     *
     * @return void
     * @since 0.1.0
     */
    public function truncate()
    {
        foreach (array_keys($this->storage) as $key) {
            unset($this->storage[$key]);
        }
    }
}
