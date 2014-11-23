<?php

namespace Etki\Environment\OperatingSystem\Shell;

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
     * @param string $command Command to run.
     *
     * @return ExecutionResult Results of execution.
     * @since 0.1.0
     */
    public function execute($command);
    /**
     * Executes command and passes all of it's output to the user.
     *
     * @param string $command Command to run.
     *
     * @return ExecutionResult Results of execution.
     * @since 0.1.0
     */
    public function passthru($command);

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
