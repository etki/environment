<?php

namespace Etki\Environment\Exception\Pattern;

use \BadMethodCallException;

/**
 * Thrown whenever notifier object can't find listener.
 *
 * If you're wondering, why this exception stands out, the answer is quite
 * simple: while most of exceptions in this library simply wave a red flag that
 * clearly indicates a fatal error *inside* the core, this one may be triggered
 * by improper use of some middleware library, and top-level developer may have
 * to catch it on top level. This is not a 'wow everything got broken'
 * exception, and any program using this library should be able to recover after
 * hitting it.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\Exception\Pattern
 * @author  Etki <etki@etki.name>
 */
class ListenerNotFoundException extends BadMethodCallException
{

}
