<?php

namespace Etki\Environment;

use Etki\Environment\OperatingSystem\Interfaces\BasicInterface;
use Etki\Environment\Variables\VariableManager;

/**
 * Base class.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment
 * @author  Etki <etki@etki.name>
 */
class Environment
{
    /**
     * Operation System class instance.
     *
     * @type BasicInterface
     * @since 0.1.0
     */
    protected $os;
    /**
     * Environmental variables.
     *
     * @type VariableManager
     * @since 0.1.0
     */
    protected $variables;

    /**
     * Retrieves shell.
     *
     * @return void
     * @since 0.1.0
     */
    public function getShell()
    {
        $this->os->getShell();
    }

    /**
     * Returns operating system class.
     *
     * @return BasicInterface
     * @since 0.1.0
     */
    public function getOs()
    {
        return $this->os;
    }
}
