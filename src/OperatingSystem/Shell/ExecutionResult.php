<?php

namespace Etki\Environment\OperatingSystem\Shell;

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
        $this->startTime = microtime(true);
    }

    /**
     * Ends command execution.
     *
     * @param string $output Execution output.
     *
     * @return void
     * @since 0.1.0
     */
    public function finish($output)
    {
        $this->endTime = microtime(true);
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
        return $this->output;
    }
}
