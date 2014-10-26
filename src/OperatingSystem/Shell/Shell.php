<?php

namespace Etki\Environment\OperatingSystem\Shell;

use RuntimeException;

/**
 * Basic shell realization.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\Shell
 * @author  Etki <etki@etki.name>
 */
class Shell implements ShellInterface
{
    /**
     * Executes provided command.
     *
     * @param string $commmand          Command to run.
     * @param bool   $suppressException If set to true, no exception will be
     *                                  thrown on error code <> 0.
     *
     * @throws RuntimeException Thrown if exit code tells run is failed and
     *                          `$suppressException` is set to false.
     *
     * @return ExecutionResult
     * @since 0.1.0
     */
    public function execute($commmand, $suppressException = false)
    {

    }

    /**
     * Executes provided command, passing it's output to user instantly.
     *
     * @param string $commmand          Command to run.
     * @param bool   $suppressException If set to true, no exception will be
     *                                  thrown on error code <> 0.
     *
     * @throws RuntimeException Thrown if exit code tells run is failed and
     *                          `$suppressException` is set to false.
     *
     * @return ExecutionResult
     * @since 0.1.0
     */
    public function passthru($command, $suppressException = false)
    {

    }

    /**
     * Runs process in the background.
     *
     * @param string $command Command to run
     *
     * @return ExecutionResult
     * @since 0.1.0
     */
    public function background($command, $suppressException = false)
    {

    }
}
