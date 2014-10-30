<?php

namespace Etki\Environment\OperatingSystem\Shell;

use RuntimeException;

/**
 * Result of a single execution.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\OperatingSystem\Shell
 * @author  Etki <etki@etki.name>
 */
class ExecutionResult
{
    /**
     * Time of the process start.
     *
     * @type float
     * @since 0.1.0
     */
    protected $startTime;
    /**
     * Time of the process end.
     *
     * @type float
     * @since 0.1.0
     */
    protected $endTime;
    /**
     * Command output.
     *
     * @type string
     * @since 0.1.0
     */
    protected $output;
    /**
     * Command exit code.
     *
     * @type int
     * @since 0.1.0
     */
    protected $exitCode;

    /**
     * Starts command execution.
     *
     * @return void
     * @since 0.1.0
     */
    public function start()
    {
        $this->assertNotStarted();
        $this->startTime = microtime(true);
    }

    /**
     * Ends command execution.
     *
     * @param int    $exitCode Exit code of execution.
     * @param string $output   Execution output.
     *
     * @return void
     * @since 0.1.0
     */
    public function finish($exitCode, $output = null)
    {
        $this->assertNotFinished();
        $this->assertStarted();
        $this->endTime = microtime(true);
        $this->exitCode = $exitCode;
        $this->output = $output;
    }

    /**
     * Returns program exit code.
     *
     * @return int
     * @since 0.1.0
     */
    public function getExitCode()
    {
        $this->assertFinished();
        return $this->exitCode;
    }

    /**
     * Returns output.
     *
     * @return string
     * @since 0.1.0
     */
    public function getOutput()
    {
        $this->assertFinished();
        return $this->output;
    }

    /**
     * Asserts that execution hasn't started yet.
     *
     * @throws RuntimeException Thrown if execution has already been started.
     *
     * @inline
     *
     * @return void
     * @since 0.1.0
     */
    protected function assertNotStarted()
    {
        $this->assertNotFinished();
        if (isset($this->startTime)) {
            throw new RuntimeException('Execution has already started');
        }
    }

    /**
     * Asserts that execution has already been started at the moment.
     *
     * @throws RuntimeException Thrown if execution hasn't been started yet.
     *
     * @inline
     *
     * @return void
     * @since 0.1.0
     */
    protected function assertStarted()
    {
        if (!isset($this->startTime)) {
            throw new RuntimeException('Execution hasn\'t been started');
        }
    }

    /**
     * Asserts that execution hasn't been finished.
     *
     * @throws RuntimeException Thrown if execution has already been finished.
     *
     * @inline
     *
     * @return void
     * @since 0.1.0
     */
    protected function assertNotFinished()
    {
        if (isset($this->endTime)) {
            throw new RuntimeException('Execution has already finished');
        }
    }

    /**
     * Asserts that execution has already finished.
     *
     * @throws RuntimeException Thrown if execution hasn't finished yet.
     *
     * @inline
     *
     * @return void
     * @since 0.1.0
     */
    protected function assertFinished()
    {
        $this->assertStarted();
        if (!isset($this->endTime)) {
            throw new RuntimeException('Execution hasn\'t finished yet');
        }
    }
}
