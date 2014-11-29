<?php

namespace Etki\Environment\OperatingSystem\Process;

use BadMethodCallException;

/**
 * Simple structure representing process status.
 *
 * @method string getCommand()
 * @method int getPid()
 * @method bool getRunning()
 * @method bool getSignaled()
 * @method bool getStopped()
 * @method int getExitCode()
 * @method int getTerminationSignal()
 * @method int getStopSignal()
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\OperatingSystem\Shell\Process
 * @author  Etki <etki@etki.name>
 */
class Status
{
    /**
     * Command that launched the process.
     *
     * @type string
     * @since 0.1.0
     */
    protected $command;
    /**
     * Process ID.
     *
     * @type int
     * @since 0.1.0
     */
    protected $pid;
    /**
     * Tells if process is running right now.
     *
     * @type bool
     * @since 0.1.0
     */
    protected $running;
    /**
     * Tells if process has been signalled.
     *
     * @type bool
     * @since 0.1.0
     */
    protected $signaled;
    /**
     * Tells if process has been stopped.
     *
     * @type bool
     * @since 0.1.0
     */
    protected $stopped;
    /**
     * Process exit code.
     *
     * @type int
     * @since 0.1.0
     */
    protected $exitCode;
    /**
     * Termination signal sent to process (if any).
     *
     * @type int
     * @since 0.1.0
     */
    protected $terminationSignal;
    /**
     * Stop signal sent to process (if any).
     *
     * @type int
     * @since 0.1.0
     */
    protected $stopSignal;

    /**
     * Creates new status from `proc_status()` output.
     *
     * @param array $processStatus `proc_status()` output.
     *
     * @return static Current class instance.
     * @since 0.1.0
     */
    public static function createFromProcStatusOutput(array $processStatus)
    {
        $status = new static;
        $status->command = $processStatus['command'];
        $status->pid = $processStatus['pid'];
        $status->running = $processStatus['running'];
        $status->signaled = $processStatus['signaled'];
        $status->stopped = $processStatus['stopped'];
        $status->exitCode = $processStatus['exitcode'];
        $status->terminationSignal = $processStatus['termsig'];
        $status->stopSignal = $processStatus['stopsig'];
        return $status;
    }

    /**
     * Generic handler for getters.
     *
     * @param string $name Method name.
     * @param array  $args Additional arguments.
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @return mixed
     * @since 0.1.0
     */
    public function __call($name, array $args = null)
    {
        $prefix = substr($name, 0, 3);
        // strtolower works even on `false`. Kekeke.
        $property = strtolower(substr($name, 3), 1) . substr($name, 4);
        if (!$property || $prefix !== 'get' || !isset($this->$property)) {
            $message = sprintf('Unknown method `%s`', $name);
            throw new BadMethodCallException($message);
        }
        return $this->$property;
    }
}
