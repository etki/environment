<?php

namespace Etki\Environment\OperatingSystem\Shell;

use RuntimeException;
use BadMethodCallException;

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
     * Unified command output.
     *
     * @type string
     * @since 0.1.0
     */
    protected $output;
    /**
     * Standard output stream.
     *
     * @type string
     * @since 0.1.0
     */
    protected $stdOut;
    /**
     * Error output stream.
     *
     * @type string
     * @since 0.1.0
     */
    protected $stdErr;
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
     * Appends output standard output stream record.
     *
     * @param string $output Output.
     *
     * @return void
     * @since 0.1.0
     */
    public function appendStdOut($output)
    {
        $this->appendStream($this->stdOut, $output);
    }

    /**
     * Appends output to standard error stream record.
     *
     * @param string $output Output.
     *
     * @return void
     * @since 0.1.0
     */
    public function appendStdErr($output)
    {
        $this->appendStream($this->stdErr, $output);
    }

    /**
     * Appends output to particular stream record and unified output record.
     *
     * @param string|null $stream Stream reference link.
     * @param string      $output Output to append.
     *
     * @return void
     * @since 0.1.0
     */
    protected function appendStream(&$stream, $output)
    {
        if (!$stream) {
            $stream = $output;
        } else {
            $stream .= $output;
        }
        if (!isset($this->output)) {
            $this->output = $output;
        } else {
            $this->output .= $output;
        }
    }

    /**
     * Ends command execution.
     *
     * @param int $exitCode Exit code of execution.
     *
     * @return void
     * @since 0.1.0
     */
    public function finish($exitCode)
    {
        $this->assertNotFinished();
        $this->assertStarted();
        $this->endTime = microtime(true);
        $this->exitCode = $exitCode;
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
        $this->assertStarted();
        return $this->output;
    }

    /**
     * Returns standard output recording.
     *
     * @return string
     * @since 0.1.0
     */
    public function getStdOut()
    {
        $this->assertStarted();
        return $this->stdOut;
    }

    /**
     * Returns standard error stream recording.
     *
     * @return string
     * @since 0.1.0
     */
    public function getStdErr()
    {
        $this->assertStarted();
        return $this->stdErr;
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
