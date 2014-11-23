<?php

namespace Etki\Environment\OperatingSystem\Shell;

use RuntimeException;
use Etki\Environment\OperatingSystem\AbstractOperatingSystem;

/**
 * Basic shell realization.
 *
 * @SuppressWarnings(PHPMD.ShortVariableName)
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\Shell
 * @author  Etki <etki@etki.name>
 */
class Shell implements CommandLineInterface
{
    /**
     * Current OS.
     *
     * @type AbstractOperatingSystem
     * @since 0.1.0
     */
    protected $os;

    /**
     * Current operating system setter.
     *
     * @param AbstractOperatingSystem $os Operating system representation.
     *
     * @SuppressWarnings(PHPMD.ShortVariableName)
     *
     * @return void
     * @since 0.1.0
     */
    public function setOs(AbstractOperatingSystem $os)
    {
        $this->os = $os;
    }

    /**
     * Executes provided command.
     *
     * @param string $command Command to run.
     *
     * @return ExecutionResult
     * @since 0.1.0
     */
    public function execute($command)
    {
        $result = new ExecutionResult;
        $result->start();
        exec($command, $output, $exitCode);
        $result->finish($exitCode, implode(PHP_EOL, $output));
    }

    /**
     * Executes provided command, passing it's output to user instantly.
     *
     * @param string $command Command to run.
     *
     * @todo refactor
     *
     * @return ExecutionResult
     * @since 0.1.0
     */
    public function passthru($command)
    {
        $result = new ExecutionResult;
        $descriptors = array(
            array('pipe', 'r'),
            array('pipe', 'w'),
            array('pipe', 'w'),
        );
        $result->start();
        $process = proc_open($command, $descriptors, $pipes, getcwd());
        if (!is_resource($process)) {
            $message = sprintf('Couldn\'t start `%s` process', $command);
            throw new RuntimeException($message);
        }
        $read = array($pipes[1], $pipes[2],);
        $write = null;
        $except = null;
        stream_set_blocking($pipes[1], 0);
        stream_set_blocking($pipes[2], 0);
        while (stream_select($read, $write, $except, null)) {
            foreach ($read as $stream) {
                $out = '';
                while ($temp = fread($stream, 1024)) {
                    $out .= $temp;
                }
                if ($stream === $pipes[1]) {
                    $selector = ExecutionResult::STDOUT;
                    //fputs(STDOUT, $out);
                    echo $out;
                } else {
                    $selector = ExecutionResult::STDERR;
                    fputs(STDERR, $out);
                }
                $result->write($out, $selector);
            }
            $status = proc_get_status($process);
            if (!$status['running']) {
                break;
            }
            $read = array($pipes[1], $pipes[2]);
        }
        $exitCode = proc_close($process);
        $result->finish($exitCode);
        return $result;
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
