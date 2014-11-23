<?php

namespace Etki\Environment\Tests\Support\Mocks\Variables\History;

use Etki\Environment\Variables\History\HistoryInterface;

/**
 * A simple history mock.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\Tests\Support\Mocks\Variables\History
 * @author  Etki <etki@etki.name>
 */
class HistoryInterfaceMock implements HistoryInterface
{
    /**
     * {@inheritdoc}
     *
     * @return array
     * @since 0.1.0
     */
    public function reset()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     * @since 0.1.0
     */
    public function snapshot()
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     * @since 0.1.0
     */
    public function getCurrentSnapshot()
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     *
     * @param string $action
     * @param string $storage
     * @param string $item
     * @param mixed  $value
     *
     * @return void
     * @since 0.1.0
     */
    public function pushAction($action, $storage, $item, $value)
    {
    }

    /**
     * {@inheritdoc}
     *
     * @param int|string $snapshot
     *
     * @return array
     * @since 0.1.0
     */
    public function moveToSnapshot($snapshot)
    {
        return array();
    }
}
