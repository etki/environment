<?php

namespace Etki\Environment\OperatingSystem\Interfaces;

/**
 * This interface provides basic design for UNIX signal compliant OS.
 *
 * @todo
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\OperatingSystem\Interfaces
 * @author  Etki <etki@etki.name>
 */
interface UnixSignalingInterface
{
    const SIGNAL_TTY_DISCONNECT = 1;
    const SIGNAL_INTERRUPT_EXECUTION = 2;
    const SIGNAL_QUIT = 3;
    const SIGNAL_ILLEGAL_INSTRUCTION = 4;
    const SIGNAL_TRAP = 5;
    const SIGNAL_ABORT_EXECUTION = 6;
    const SIGNAL_ARITHMETIC_EXCEPTION = 8;
    const SIGNAL_KILL = 9;
    const SIGNAL_BUS_ERROR = 10;
    const SIGNAL_SEGMENTATION_VIOLATION = 11;
    const SIGNAL_BAD_SYSTEM_CALL = 12;
    const SIGNAL_MISSING_PIPE_LISTENERS = 13;
    const SIGNAL_ALARM = 14;
    const SIGNAL_TERMINATE_EXECUTION = 15;
    const SIGNAL_USER_DEFINED = 16;
    const SIGNAL_USER_DEFINED_2 = 17;
    const SIGNAL_CHILD_PROCESS_TERMINATED = 18;
    const SIGNAL_TEMPORARILY_STOP_EXECUTION = 20;
    const SIGNAL_URGENT_SOCKET_DATA = 21;
    const SIGNAL_POLL = 22;
    const SIGNAL_STOP_EXECUTION = 23;
    const SIGNAL_CONTINUE_EXECUTION = 25;
    const SIGNAL_TTY_READ_FROM_BACKGROUND = 26;
    const SIGNAL_TTY_WRITE_FROM_BACKGROUND = 27;
    const SIGNAL_VIRTUAL_TIMER_EXPIRED = 28;
    const SIGNAL_PROFILING_TIMER_EXPIRED = 29;
    const SIGNAL_CPU_TIME_LIMIT_EXCEEDED = 30;
    const SIGNAL_FILE_SIZE_LIMIT_EXCEEDED = 31;

    const SIGHUP = self::SIGNAL_TTY_DISCONNECT;
    const SIGINT = self::SIGNAL_INTERRUPT_EXECUTION;
    const SIGQUIT = self::SIGNAL_QUIT;
    const SIGILL = self::SIGNAL_ILLEGAL_INSTRUCTION;
    const SIGTRAP = self::SIGNAL_TRAP;
    const SIGABRT = self::SIGNAL_ABORT_EXECUTION;
    const SIGFPE = self::SIGNAL_ARITHMETIC_EXCEPTION;
    const SIGKILL = self::SIGNAL_KILL;
    const SIGBUS = self::SIGNAL_BUS_ERROR;
    const SIGSEGV = self::SIGNAL_SEGMENTATION_VIOLATION;
    const SIGSYS = self::SIGNAL_BAD_SYSTEM_CALL;
    const SIGPIPE = self::SIGNAL_MISSING_PIPE_LISTENERS;
    const SIGALRM = self::SIGNAL_ALARM;
    const SIGTERM = self::SIGNAL_TERMINATE_EXECUTION;
    const SIGUSR1 = self::SIGNAL_USER_DEFINED;
    const SIGUSR2 = self::SIGNAL_USER_DEFINED_2;
    const SIGCHLD = self::SIGNAL_CHILD_PROCESS_TERMINATED;
    const SIGTSTP = self::SIGNAL_TEMPORARILY_STOP_EXECUTION;
    const SIGPOLL = self::SIGNAL_POLL;
    const SIGSTOP = self::SIGNAL_STOP_EXECUTION;
    const SIGCONT = self::SIGNAL_CONTINUE_EXECUTION;
    const SIGTTIN = self::SIGNAL_TTY_READ_FROM_BACKGROUND;
    const SIGTTOU = self::SIGNAL_TTY_WRITE_FROM_BACKGROUND;
    const SIGVTALRM = self::SIGNAL_VIRTUAL_TIMER_EXPIRED;
    const SIGPROF = self::SIGNAL_PROFILING_TIMER_EXPIRED;
    const SIGXCPU = self::SIGNAL_CPU_TIME_LIMIT_EXCEEDED;
    const SIGXFSZ = self::SIGNAL_FILE_SIZE_LIMIT_EXCEEDED;

    /**
     * Sends signal to specified process.
     *
     * @param int $pid    Process identifier.
     * @param int $signal Signal to send, preferrably referenced by one of the
     *                    `self::SIGNAL_*` constants.
     *
     * @return void
     * @since 0.1.0
     */
    public function signal($pid, $signal);

    /**
     * Kills selected process.
     *
     * @param int $pid PID of the process to kill.
     *
     * @return void
     * @since 0.1.0
     */
    public function kill($pid);

    /**
     * Gracefully interrupts process.
     *
     * @param int $pid Process ID.
     *
     * @return void
     * @since 0.1.0
     */
    public function interrupt($pid);

    /**
     * Stops selected process.
     *
     * @param int $pid Process ID.
     *
     * @return void
     * @since 0.1.0
     */
    public function stop($pid);

    /**
     * Resumes process operation.
     *
     * @param int $pid Process ID.
     *
     * @return void
     * @since 0.1.0
     */
    public function resume($pid);
}
