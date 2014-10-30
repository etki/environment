<?php

namespace Etki\Environment\Interpreter;

/**
 * Provides basic information about interpreter.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\Interpreter
 * @author  Etki <etki@etki.name>
 */
class Interpreter
{
    /**
     * Returns path to PHP binary.
     *
     * @return string
     * @since 0.1.0
     */
    public function getBinary()
    {
        if (defined('PHP_BINARY')) {
            return PHP_BINARY;
        }
        // fffuuuuuu
        return PHP_BINDIR . DIRECTORY_SEPARATOR . 'php';
    }

    /**
     * Returns PHP version.
     *
     * @return string
     * @since 0.1.0
     */
    public function getVersion()
    {
        return sprintf(
            '%d.%d.%d',
            PHP_MAJOR_VERSION,
            PHP_MINOR_VERSION,
            PHP_RELEASE_VERSION
        );
    }

    /**
     * Returns current PHP version signature with `-extra` tail.
     *
     * @return string
     * @since 0.1.0
     */
    public function getVersionSignature()
    {
        return PHP_VERSION;
    }

    /**
     * Tells if PHP session is enabled.
     *
     * @return bool
     * @since 0.1.0
     */
    public function isSessionEnabled()
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    /**
     * Returns list of extensions.
     *
     * @return string[]
     * @since 0.1.0
     */
    public function getExtensions()
    {
        return get_loaded_extensions();
    }
}
