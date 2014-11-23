<?php

namespace Etki\Environment\Patterns;

use BadMethodCallException;
use Etki\Environment\Exception\Pattern\ListenerNotFoundException;

/**
 * A simple notifier pattern.
 *
 * Yeah, that's better to be trait, but i'm trying to support 5.3.0 here.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\Patterns
 * @author  Etki <etki@etki.name>
 */
class Notifier
{
    /**
     * Listeners stack.
     *
     * @type callable[]
     * @since 0.1.0
     */
    protected $listeners = array();

    /**
     * Adds single listener to stack.
     *
     * @param callable $listener Listener to add,
     *
     * @return void
     * @since 0.1.0
     */
    public function addListener($listener)
    {
        if (!is_callable($listener)) {
            $message = 'Passed listener is not callable';
            throw new BadMethodCallException($message);
        }
        $this->listeners[] = $listener;
    }

    /**
     * Removes listener from stack.
     *
     * @param callable $listener Listener to pop out.
     *
     * @return void
     * @since 0.1.0
     */
    public function removeListener($listener)
    {
        foreach ($this->listeners as $key => $storedListener) {
            if ($storedListener === $listener) {
                unset($this->listeners[$key]);
                return;
            }
        }
        $message = 'Couldn\'t find listener to remove';
        throw new ListenerNotFoundException($message);
    }

    /**
     * Tells if current instance has specified listener.
     *
     * @param callable $listener Listener to check.
     *
     * @return bool
     * @since 0.1.0
     */
    public function hasListener($listener)
    {
        return in_array($listener, $this->listeners, true);
    }

    /**
     * Notifies listeners using all provided parameters. Please note that there
     * may be no parameters at all.
     *
     * @return void
     * @since 0.1.0
     */
    protected function notify()
    {
        $args = func_get_args();
        foreach ($this->listeners as $listener) {
            call_user_func_array($listener, $args);
        }
    }
}
