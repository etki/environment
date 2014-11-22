<?php

namespace Etki\Environment\Support;

/**
 * Simple autoloader that should be used in composerless environments.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\Support
 * @author  Etki <etki@etki.name>
 */
class Autoloader
{
    /**
     * Namespaces in [namespace => directory] format.
     *
     * @type string[]
     * @since 0.1.0
     */
    protected $namespaces = array();
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
        $namespace = trim($namespace, '\\');
        $this->namespaces[$namespace] = $root;
    }

    /**
     * Loads class by it's FQCN.
     *
     * @param string $className Name of the class.
     *
     * @return bool Whether class file was read successfully or not.
     * @since 0.1.0
     */
    public function loadClass($className)
    {
        $className = trim($className, '\\');
        $candidate = null;
        foreach (array_keys($this->namespaces) as $namespace) {
            if (strpos($className, $namespace . '\\') === 0
                && (!$candidate || strlen($namespace) > strlen($candidate))
            ) {
                $candidate = $namespace;
            }
        }
        if (!$candidate) {
            return false;
        }
        $directory = $this->namespaces[$candidate];
        $relativeClassName = substr($className, strlen($candidate));
        $dirSep = DIRECTORY_SEPARATOR;
        $relativePath = str_replace('\\', $dirSep, $relativeClassName);
        $path = $directory . $relativePath . '.php';
        if (!file_exists($path) || !is_readable($path)) {
            return false;
        }
        include $path;
        return true;
    }

    /**
     * Registers autoload in the SPL autoloader stack.
     *
     * @return void
     * @since 0.1.0
     */
    public function register()
    {
        spl_autoload_register(array($this, 'loadClass'));
    }

    /**
     * Unregisters class in SPL autoload system.
     *
     * @return void
     * @since 0.1.0
     */
    public function unregister()
    {
        spl_autoload_unregister(array($this, 'loadClass'));
    }
}
