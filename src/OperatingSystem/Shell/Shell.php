<?php

namespace Etki\Environment\OperatingSystem\Shell;

use RuntimeException;

/**
 * Basic shell realization.
 *
 * @todo exceptions
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\Shell
 * @author  Etki <etki@etki.name>
 */
class Shell implements CommandLineInterface
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
        $result = new ExecutionResult;
        $result->start();
        exec($commmand, $output, $exitCode);
        $result->finish($exitCode, implode(PHP_EOL, $output));
    }

    /**
     * Executes provided command, passing it's output to user instantly.
     *
     * @param string $command           Command to run.
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
        $result = new ExecutionResult;
        $result->start();
        passthru($command, $exitCode);
        $result->finish($exitCode);
    }

    /**
     * Runs process in the background.
     *
     * @param string $command Command to run
     *
     * @return ExecutionResult Results.
     * @since 0.1.0
     */
    public function background($command)
    {
        return $this->execute($command . ' 2>&1 &');
    }
}
