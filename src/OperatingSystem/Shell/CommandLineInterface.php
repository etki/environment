<?php

namespace Etki\Environment\OperatingSystem\Shell;

use RuntimeException;

/**
 * Basic shell interface.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\OperatingSystem\Shell
 * @author  Etki <etki@etki.name>
 */
interface CommandLineInterface
{
    /**
     * Executes command.
     *
     * @param string $command           Command to run.
     * @param bool   $suppressException If set to true, method won't throw
     *                                  exception on failed run.
     *
     * @throws RuntimeException Thrown if non-zero exit code is returned and
     *                          $suppressException is set to false.
     *
     * @return ExecutionResult Results of execution.
     * @since 0.1.0
     */
    public function execute($command, $suppressException = false);
    /**
     * Executes command and passes all of it's output to the user.
     *
     * @param string $command           Command to run.
     * @param bool   $suppressException If set to true, method won't throw
     *                                  exception on failed run.
     *
     * @throws RuntimeException Thrown if non-zero exit code is returned and
     *                          $suppressException is set to false.
     *
     * @return ExecutionResult Results of execution.
     * @since 0.1.0
     */
    public function passthru($command, $suppressException = false);

    /**
     * Runs command in background.
     *
     * @param string $command Command to run.
     *
     * @return void
     * @since 0.1.0
     */
    public function background($command);
}
