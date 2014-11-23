<?php

namespace Etki\Environment\Variables\History;

/**
 * Standardized history interface.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\Variables\History
 * @author  Etki <etki@etki.name>
 */
interface HistoryInterface
{
    /**
     * Pushes action to stack.
     *
     * @param string $action  Action ID.
     * @param string $storage Storage ID.
     * @param string $item    Item ID.
     * @param mixed  $value   Item value.
     *
     * @return void
     * @since 0.1.0
     */
    public function pushAction($action, $storage, $item, $value);

    /**
     * Creates new snapshot and returns it's ID.
     *
     * @return int|string Snapshot ID.
     * @since 0.1.0
     */
    public function snapshot();

    /**
     * Moves history to snapshot X.
     *
     * @param int|string $snapshot Snapshot ID.
     *
     * @return array Change history.
     * @since 0.1.0
     */
    public function moveToSnapshot($snapshot);

    /**
     * Returns current snapshot ID.
     *
     * @return int|string Snapshot ID.
     * @since 0.1.0
     */
    public function getCurrentSnapshot();

    /**
     * Resets whole history.
     *
     * @return array History that is being reset.
     * @since 0.1.0
     */
    public function reset();
}
