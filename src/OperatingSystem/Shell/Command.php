<?php

namespace Etki\Environment\OperatingSystem\Shell;

use RuntimeException;

/**
 *
 *
 * @version 0.1.0
 * @since   
 * @package Etki\Environment\OperatingSystem\Shell
 * @author  Etki <etki@etki.name>
 */
class Command
{
    protected $command;
    protected $os;
    protected $backgroundWrapper;
    public function __construct($command)
    {
        $this->command = $command;
    }
    public function setBackgroundWrapper($wrapper)
    {
        $this->backgroundWrapper = $wrapper;
    }
    public function run(
        $background = false,
        $realtimeOutput = false,
        $workingDirectory = null
    ) {
        $workingDirectory = $workingDirectory ? $workingDirectory : getcwd();
        $process = $this->createProcess($background, $workingDirectory);
        $process = new Process;
        $result = new ExecutionResult;
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
