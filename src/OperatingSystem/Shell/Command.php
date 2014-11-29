<?php

namespace Etki\Environment\OperatingSystem\Shell;

use Etki\Environment\Exception\NotImplementedException;
use Etki\Environment\OperatingSystem\Process\Process;
use Etki\Environment\OperatingSystem\Process\Result;
use RuntimeException;

/**
 * This class represents single CLI command.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\OperatingSystem\Shell
 * @author  Etki <etki@etki.name>
 */
class Command
{
    /**
     * Command itself.
     *
     * @type string
     * @since 0.1.0
     */
    protected $command;
    /**
     * OS-dependent command wrapper to run it in background mode.
     *
     * @type string
     * @since 0.1.0
     */
    protected $backgroundWrapper;

    /**
     * Initializer.
     *
     * @param string $command Command to run.
     *
     * @return self
     * @since 0.1.0
     */
    public function __construct($command)
    {
        $this->command = $command;
    }

    /**
     * Background wrapper setter.
     *
     * @param string $wrapper Wrapper.
     *
     * @return void
     * @since 0.1.0
     */
    public function setBackgroundWrapper($wrapper)
    {
        $this->backgroundWrapper = $wrapper;
    }

    /**
     * Runs command.
     *
     * @param bool   $background       Whether command should be ran in
     *                                 background or not
     * @param bool   $realtimeOutput   If set to true, command will provide
     *                                 realtime output.
     * @param string $workingDirectory Path to directory in which command should
     *                                 be run.
     *
     * @return void
     * @since 0.1.0
     */
    public function run(
        $background = false,
        $realtimeOutput = false,
        $workingDirectory = null
    ) {
        throw new NotImplementedException;
        $workingDirectory = $workingDirectory ? $workingDirectory : getcwd();
        $process = $this->createProcess($background, $workingDirectory);
        $process = new Process;
        $result = new Result;
        $result->start();
        $pipes = $process->run();
        list($stdout, $stderr) = $streams = array_slice($pipes, 1, 2);
        foreach ($streams as $pipe) {
            stream_set_blocking($pipe, 0);
        }
        $readStreams = $streams;
        $writeStreams = $exStreams = null;
        while (stream_select($readStreams, $writeStreams, $exStreams, null)) {

        }
    }

    /**
     * Creates new process.
     *
     * @param bool   $background       If set to true, process will be ran in
     *                                 background.
     * @param string $workingDirectory Path in which process should be ran.
     *
     * @return Process Created process.
     * @since 0.1.0
     */
    protected function createProcess($background, $workingDirectory)
    {
        $command = $this->command;
        if ($background) {
            if (!isset($this->backgroundWrapper)) {
                $message = 'Can\'t perform background call: no background ' .
                    'wrapper set';
                throw new RuntimeException($message);
            }
            $command = sprintf($this->backgroundWrapper, $command);
        }
        $descriptors = array(
            array('pipe', 'r',),
            array('pipe', 'w',),
            array('pipe', 'w',),
        );
        return new Process($command, $descriptors, $workingDirectory);
    }
}
