<?php

namespace Etki\Environment\Variables\History;

use BadMethodCallException;

/**
 * Saves the history of environment changes as a consecutive list of actions
 * taken.
 *
 * Please note that change and snapshot stacks are not zero-based.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\Variables
 * @author  Etki <etki@etki.name>
 */
class ConsecutiveHistory implements HistoryInterface
{
    /**
     * List of snapshots, each pointing
     *
     * @type int[]
     * @since 0.1.0
     */
    protected $snapshots = array();
    /**
     * List of actions.
     *
     * @type array
     * @since 0.1.0
     */
    protected $history = array();
    /**
     * Cursor to current history step.
     *
     * @type int
     * @since 0.1.0
     */
    protected $cursor;
    /**
     * Pointer to current snapshot.
     *
     * @type int
     * @since 0.1.0
     */
    protected $currentSnapshot;

    /**
     * Pushes new action to history.
     *
     * @param string $action  Action ID.
     * @param string $storage Storage ID.
     * @param string $item    Item ID.
     * @param mixed  $value   Value pushed.
     *
     * @return void
     * @since 0.1.0
     */
    public function pushAction($action, $storage, $item, $value)
    {
        if (!$this->cursor) {
            $this->cursor = 0;
        }
        $step = array($action, $storage, $item, $value);
        $this->history[++$this->cursor] = $step;
        // removing obsolete snapshots
        while (sizeof($this->snapshots) > $this->currentSnapshot + 1) {
            array_pop($this->snapshots);
        }
    }

    /**
     * Creates new snapshot.
     *
     * @return int Snapshot ID.
     * @since 0.1.0
     */
    public function snapshot()
    {
        if (!$this->currentSnapshot) {
            $this->currentSnapshot = 0;
        }
        $this->snapshots[++$this->currentSnapshot] = $this->cursor;
        return $this->currentSnapshot;
    }

    /**
     * Moves history to specified snapshot.
     *
     * @param int $snapshot ID of snapshot.
     *
     * @return array List of changes between current position and selected
     * snapshot.
     * @since 0.1.0
     */
    public function moveToSnapshot($snapshot)
    {
        if (!isset($this->snapshots[$snapshot])) {
            $message = 'Invalid snapshot ID';
            throw new BadMethodCallException($message);
        }
        $cursor = $this->cursor;
        $target = $this->snapshots[$snapshot];
        $this->cursor = $target;
        $this->currentSnapshot = $snapshot;
        return $this->getSlice($cursor, $target);
    }

    /**
     * Returns current snapshot ID.
     *
     * @return int
     * @since 0.1.0
     */
    public function getCurrentSnapshot()
    {
        return $this->currentSnapshot;
    }

    /**
     * Returns current state number.
     *
     * @return int
     * @since 0.1.0
     */
    public function getCurrentState()
    {
        return $this->cursor;
    }

    /**
     * Resets whole history.
     *
     * @return array History being reset.
     * @since 0.1.0
     */
    public function reset()
    {
        $history = array_slice($this->history, 0, $this->cursor);
        $this->history = array();
        $this->currentSnapshot = null;
        $this->cursor = null;
        $this->snapshots = array();
        return $history;
    }

    /**
     * Returns list of changes between state A and state B.
     *
     * @param int $stateA Index of state A.
     * @param int $stateB Index of state B.
     *
     * @return array List of changes.
     * @since 0.1.0
     */
    protected function getSlice($stateA, $stateB)
    {
        if ($stateA > $stateB) {
            list($stateA, $stateB) = array($stateB, $stateA);
        }
        return array_slice($this->history, $stateA, $stateB - $stateA);
    }
}
