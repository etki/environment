<?php

namespace Etki\Environment\OperatingSystem\Interfaces;

use Etki\Environment\OperatingSystem\Shell\ExecutionResult;

/**
 * This interface is made for operating systems that have package manager.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\OperatingSystem
 * @author  Etki <etki@etki.name>
 */
interface InstallCapableInterface
{
    /**
     * Installs provided package(s).
     *
     * @param string|string[] $packages Package or list of packages to install.
     *
     * @return ExecutionResult Operation result.
     * @since 0.1.0
     */
    public function install($packages);
}
