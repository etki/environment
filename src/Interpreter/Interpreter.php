<?php

namespace Etki\Environment\Interpreter;

use Etki\Environment\OperatingSystem\Interfaces\BasicOsInterface;

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
     * Current OS.
     *
     * @type BasicOsInterface
     * @since 0.1.0
     */
    protected $operatingSystem;

    /**
     * Initializer.
     *
     * @param BasicOsInterface $operatingSystem Current operating system.
     *
     * @codeCoverageIgnore
     *
     * @return self
     * @since 0.1.0
     */
    public function __construct(BasicOsInterface $operatingSystem)
    {
        $this->operatingSystem = $operatingSystem;
    }
    /**
     * Returns path to PHP binary.
     *
     * @codeCoverageIgnore
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
        $path = PHP_BINDIR . DIRECTORY_SEPARATOR . 'php';
        $windowsFamily = BasicOsInterface::FAMILY_WINDOWS;
        if ($this->operatingSystem->belongsTo($windowsFamily)) {
            $path .= '.exe';
        }
        return $path;
    }

    /**
     * Returns PHP version.
     *
     * @codeCoverageIgnore
     *
     * @return string
     * @since 0.1.0
     */
    public function getVersion()
    {
        // because `phpversion()` will return `-extra` tail as well.
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
     * @codeCoverageIgnore
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
     * @codeCoverageIgnore
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
     * @codeCoverageIgnore
     *
     * @return string[]
     * @since 0.1.0
     */
    public function getExtensions()
    {
        return get_loaded_extensions();
    }
}
