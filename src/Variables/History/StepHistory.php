<?php

namespace Etki\Environment\Variables\History;

use Etki\Environment\Exception\NotImplementedException;

/**
 * Subject to be done. This history is intended to save snapshots as steps,
 * something like a changelog. Staging area would be realized then as a detached
 * step, so if you rewind and make some changes, you still can rewind back
 * just staging area and move forward to undeleted snapshots. This would also
 * consume less resources.
 *
 * @version 0.1.0
 * @since
 * @package Etki\Environment\Variables
 * @author  Etki <etki@etki.name>
 */
class StepHistory implements HistoryInterface
{
    /**
     * {@inheritdoc}
     *
     * @param string $action  Action ID.
     * @param string $storage Storage ID.
     * @param string $item    Item ID.
     * @param mixed  $value   Item value.
     *
     * @return void
     * @since 0.1.0
     */
    public function pushAction($action, $storage, $item, $value)
    {
        throw new NotImplementedException;
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     * @since 0.1.0
     */
    public function snapshot()
    {
        throw new NotImplementedException;
    }

    /**
     * {@inheritdoc
     *
     * @param int $snapshot Snapshot ID.
     *
     * @return array Changelist.
     * @since 0.1.0
     */
    public function moveToSnapshot($snapshot)
    {
        throw new NotImplementedException;
    }

    /**
     * {@inheritdoc}
     *
     * @return int|string Current snapshot ID.
     * @since 0.1.0
     */
    public function getCurrentSnapshot()
    {
        throw new NotImplementedException;
    }

    /**
     * {@inheritdoc}
     *
     * @return array History that is being rewritten.
     * @since 0.1.0
     */
    public function reset()
    {
        throw new NotImplementedException;
    }
}
