<?php

namespace Etki\Environment\Support;

/**
 * Simple autoloader that should be used in composerless environments.
 *
 * @todo
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\Support
 * @author  Etki <etki@etki.name>
 */
class Autoloader
{
    /**
     * Adds namespace to autoloading stack.
     *
     * @param string $namespace Namespace to be added.
     * @param string $root      Namespace root.
     *
     * @return void
     * @since 0.1.0
     */
    public function add($namespace, $root)
    {

    }

    /**
     * Registers autoload in the SPL autoloader stack.
     *
     * @return void
     * @since 0.1.0
     */
    public function register()
    {

    }
}
