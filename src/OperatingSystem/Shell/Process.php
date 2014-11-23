<?php

namespace Etki\Environment\OperatingSystem\Shell;

use BadMethodCallException;
use RuntimeException;

/**
 * Just a process class.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\OperatingSystem\Shell
 * @author  Etki <etki@etki.name>
 */
class Process
{
    /**
     * Internal PHP process resource handle.
     *
     * @type resource
     * @since 0.1.0
     */
    protected $handle;
    /**
     * Command text.
     *
     * @type string
     * @since 0.1.0
     */
    protected $command;
    /**
     * Result of the run.
     *
     * @type ExecutionResult
     * @since 0.1.0
     */
    protected $result;
    /**
     * List of pipes attached to process (stdin, stdout and stderr).
     *
     * @type resource[]
     * @since 0.1.0
     */
    protected $pipes;

    /**
     * Runs process.
     *
     * @param string $workingDirectory Directory to run in.
     *
     * @return void
     * @since 01.0
     */
    public function run($workingDirectory, array $env = null)
    {
        $this->assertNotStarted();
        $descriptors = array(
            array('pipe', 'r',),
            array('pipe', 'w',),
            array('pipe', 'w',),
        );
        $this->handle = proc_open(
            $this->command,
            $descriptors,
            $this->pipes,
            $workingDirectory,
            $env
        );
        if (!is_resource($this->handle)) {
            throw new RuntimeException;
        }
    }

    /**
     * Returns status of current process.
     *
     * @return array
     * @since 0.1.0
     */
    public function getStatus()
    {
        $this->assertHasStarted();
        return proc_get_status($this->handle);
    }

    /**
     * Tells if process is live.
     *
     * @return bool
     * @since 0.1.0
     */
    public function isRunning()
    {
        $status = $this->getStatus();
        return isset($status['running']) && $status['running'];
    }

    /**
     * Verifies that process hasn't been started yet.
     *
     * @throws BadMethodCallException
     *
     * @inline
     *
     * @return void
     * @since 0.1.0
     */
    protected function assertNotStarted()
    {
        if (isset($this->result)) {
            $message = ' The process hasn\'t been started yet.';
            throw new BadMethodCallException($message);
        }
    }

    /**
     * Verifies that process has been started.
     *
     * @throws BadMethodCallException
     *
     * @inline
     *
     * @return void
     * @since 0.1.0
     */
    protected function assertHasStarted()
    {
        if (!isset($this->result)) {
            $message = ' The process has been started already.';
            throw new BadMethodCallException($message);
        }
    }
}
