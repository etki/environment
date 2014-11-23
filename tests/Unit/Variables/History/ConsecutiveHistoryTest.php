<?php

namespace Etki\Environment\Tests\Unit\Variables\History;

use Etki\Environment\Variables\History\ConsecutiveHistory;

/**
 * Tests consecutive history class.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\Tests\Unit\Variables\History
 * @author  Etki <etki@etki.name>
 */
class ConsecutiveHistoryTest extends \Codeception\TestCase\Test
{
    /**
     * Tested class FQCN
     *
     * @type string
     * @since 0.1.0
     */
    const TESTED_CLASS
        = 'Etki\Environment\Variables\History\ConsecutiveHistory';

    /**
     * Returns new history instance.
     *
     * @return ConsecutiveHistory
     * @since 0.1.0
     */
    public function getHistory()
    {
        $className = self::TESTED_CLASS;
        return new $className;
    }

    /**
     * Provides sample snapshots.
     *
     * @return array Sample snapshots.
     * @since 0.1.0
     */
    public function sampleSnapshots()
    {
        return array(
            array(
                array('action-1', 'storage', 'item', 'value',),
            ),
            array(
                array('action-2', 'storage', 'item', 'value',),
                array('action-3', 'storage', 'item', 'value',),
                array('action-4', 'storage', 'item', 'value',),
            )
        );
    }

    // tests

    /**
     * Tests basic history functionality.
     *
     * @return void
     * @since 0.1.0
     */
    public function testConsecutiveHistory()
    {
        $snapshots = $this->sampleSnapshots();
        $history = $this->getHistory();
        $this->assertNull($history->getCurrentState());
        $this->assertNull($history->getCurrentSnapshot());
        foreach ($snapshots[0] as $action) {
            call_user_func_array(array($history, 'pushAction'), $action);
        }
        $snapshot = $history->snapshot();
        $this->assertSame($history->getCurrentSnapshot(), $snapshot);
        foreach ($snapshots[1] as $action) {
            call_user_func_array(array($history, 'pushAction'), $action);
        }
        $secondSnapshot = $history->snapshot();
        $this->assertSame($history->getCurrentSnapshot(), $secondSnapshot);
        $this->assertSame(
            $snapshots[1],
            $history->moveToSnapshot($snapshot)
        );
        $this->assertSame($history->getCurrentSnapshot(), $snapshot);
        $this->assertSame(
            $snapshots[1],
            $history->moveToSnapshot($secondSnapshot)
        );
        $this->assertSame($history->getCurrentSnapshot(), $secondSnapshot);
        $this->assertSame(
            array(),
            $history->moveToSnapshot($secondSnapshot)
        );
        $this->assertSame($history->getCurrentSnapshot(), $secondSnapshot);
    }

}
