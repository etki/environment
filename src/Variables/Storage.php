<?php

namespace Etki\Environment\Variables;

use ArrayAccess;
use Etki\Environment\Patterns\Notifier;

/**
 * Simple variable storage wrap that controls underlying level.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\Variables
 * @author  Etki <etki@etki.name>
 */
class Storage extends Notifier
{
    /**
     * Storage itself.
     *
     * @type array|ArrayAccess
     * @since 0.1.0
     */
    protected $storage;
    /**
     * Storage identifier.
     *
     * @type string
     * @since 0.1.0
     */
    protected $identifier;

    /**
     * Creates instance.
     *
     * @param array|ArrayAccess $storage   Real value storage.
     * @param string            $storageId Storage identifier.
     *
     * @return self
     * @since 0.1.0
     */
    public function __construct(&$storage, $storageId = null)
    {
        $this->storage = &$storage;
        $this->identifier = $storageId;
    }

    /**
     * Returns storage identifier, if any has been set.
     *
     * @return string
     * @since 0.1.0
     */
    public function getId()
    {
        return $this->identifier;
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
