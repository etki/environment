<?php

namespace Etki\Environment\Tests\Unit\OperatingSystem\Process;

use Codeception\TestCase\Test;
use Etki\Environment\OperatingSystem\Process\Result;
use RuntimeException;
use BadMethodCallException;

/**
 * Tests process result for correct behavior.
 *
 * @coversDefaultClass \Etki\Environment\OperatingSystem\Process\Result
 *
 * @SuppressWarnings(PHPMD.TooManyMethods)
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\Tests\Unit\OperatingSystem\Process
 * @author  Etki <etki@etki.name>
 */
class ResultTest extends Test
{
    /**
     * Returns instance of tested class.
     *
     * @return Result
     * @since 0.1.0
     */
    protected function getInstance()
    {
        return new Result;
    }

    // functional shortcuts

    /**
     * Invalid usage shortcut.
     *
     * @throws BadMethodCallException
     *
     * @return void
     * @since 0.1.0
     */
    public function invalidUsageSecondStart()
    {
        $this->getInstance()->start()->finish(0)->start();
    }

    /**
     * Invalid usage shortcut.
     *
     * @throws BadMethodCallException
     *
     * @return void
     * @since 0.1.0
     */
    public function invalidUsageDoubleStart()
    {
        $this->getInstance()->start()->start();
    }

    /**
     * Invalid usage shortcut.
     *
     * @throws BadMethodCallException
     *
     * @return void
     * @since 0.1.0
     */
    public function invalidUsagePrematureStdErrAppending()
    {
        $this->getInstance()->appendStdErr('Oh my god');
    }

    /**
     * Invalid usage shortcut.
     *
     * @throws BadMethodCallException
     *
     * @return void
     * @since 0.1.0
     */
    public function invalidUsagePrematureStdOutAppending()
    {
        $this->getInstance()->appendStdOut('Oh my god');
    }

    /**
     * Invalid usage shortcut.
     *
     * @throws BadMethodCallException
     *
     * @return void
     * @since 0.1.0
     */
    public function invalidUsagePrematureFinish()
    {
        $this->getInstance()->finish(0);
    }

    /**
     * Invalid usage shortcut.
     *
     * @throws BadMethodCallException
     *
     * @return void
     * @since 0.1.0
     */
    public function invalidUsagePrematureStdOutGetting()
    {
        $this->getInstance()->getStdOut();
    }

    /**
     * Invalid usage shortcut.
     *
     * @throws BadMethodCallException
     *
     * @return void
     * @since 0.1.0
     */
    public function invalidUsagePrematureStdErrGetting()
    {
        $this->getInstance()->getStdErr();
    }

    /**
     * Invalid usage shortcut.
     *
     * @throws BadMethodCallException
     *
     * @return void
     * @since 0.1.0
     */
    public function invalidUsagePrematureOutputGetting()
    {
        $this->getInstance()->getOutput();
    }

    /**
     * Invalid usage shortcut.
     *
     * @throws BadMethodCallException
     *
     * @return void
     * @since 0.1.0
     */
    public function invalidUsagePrematureExitCodeGettingA()
    {
        $this->getInstance()->getExitCode();
    }

    /**
     * Invalid usage shortcut.
     *
     * @throws BadMethodCallException
     *
     * @return void
     * @since 0.1.0
     */
    public function invalidUsagePrematureExitCodeGettingB()
    {
        $this->getInstance()->start()->getExitCode();
    }

    // shortcut providers

    /**
     * Data providers that returns names of shortcut methods that have to
     * trigger an exception.
     *
     * @return string[][]
     * @since 0.1.0
     */
    public function invalidUsageDataProvider()
    {
        return array(
            array('invalidUsageSecondStart',),
            array('invalidUsageDoubleStart',),
            array('invalidUsagePrematureStdOutAppending',),
            array('invalidUsagePrematureStdErrAppending',),
            array('invalidUsagePrematureFinish',),
            array('invalidUsagePrematureStdOutGetting',),
            array('invalidUsagePrematureStdErrGetting',),
            array('invalidUsagePrematureOutputGetting',),
            array('invalidUsagePrematureExitCodeGettingA',),
            array('invalidUsagePrematureExitCodeGettingB',),
        );
    }

    // tests

    /**
     * Tests all `append*()` methods.
     *
     * @return void
     * @since 0.1.0
     */
    public function testAppending()
    {
        $result = $this->getInstance()->start()->finish(0);
        $this->assertEmpty($result->getStdErr());

        $dummy = 'dummy string';

        $result = $this->getInstance()->start()->appendStdErr($dummy);
        $this->assertSame($dummy, $result->finish(0)->getStdErr());

        $result = $this->getInstance()->start()->appendStdOut($dummy);
        $this->assertSame($dummy, $result->finish(0)->getStdOut());

        $result = $this
            ->getInstance()
            ->start()
            ->appendStdOut($dummy)
            ->appendStdOut($dummy)
            ->appendStdErr($dummy)
            ->finish(0);
        $this->assertSame(str_repeat($dummy, 3), $result->getOutput());
        $this->assertSame($dummy . $dummy, $result->getStdOut());
    }

    /**
     * Verifies that inner assertions safely pass through on valid usage.
     *
     * @return void
     * @since 0.1.0
     */
    public function testSafeAssertions()
    {
        $this->getInstance()->start()->finish(0)->getExitCode();
    }

    /**
     * Verifies that invalid usage causes exceptions to be thrown.
     *
     * @dataProvider invalidUsageDataProvider
     * @expectedException RuntimeException
     *
     * @return void
     * @since 0.1.0
     */
    public function testInvalidUsagePrevention($methodName)
    {
        call_user_func(array($this, $methodName));
    }
}
