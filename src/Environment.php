<?php

namespace Etki\Environment;

use Etki\Environment\OperatingSystem\Interfaces\BasicInterface;
use Etki\Environment\Variables\History\ConsecutiveHistory;
use Etki\Environment\Variables\History\StepHistory;
use Etki\Environment\Variables\Manager as VariablesManager;
use Etki\Environment\Interpreter\Interpreter;
use Etki\Environment\OperatingSystem\Shell\CommandLineInterface;
use BadMethodCallException;

/**
 * Base class.
 *
 * @property BasicInterface $os
 * @property CommandLineInterface $shell
 * @property VariablesManager $variables
 *
 * @SuppressWarnings(PHPMD.ShortVariableName)
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment
 * @author  Etki <etki@etki.name>
 */
class Environment
{
    /**
     * Operation System class instance.
     *
     * @type BasicInterface
     * @since 0.1.0
     */
    protected $os;
    /**
     * Environmental variables.
     *
     * @type VariablesManager
     * @since 0.1.0
     */
    protected $variables;
    /**
     * PHP interpreter representation.
     *
     * @type Interpreter
     * @since 0.1.0
     */
    protected $interpreter;

    /**
     * Initializer.
     *
     * @param array $config Configuration values.
     *
     * @return self
     * @since 0.1.0
     */
    public function __construct(array $config = array())
    {
        $this->interpreter = new Interpreter;
        //$this->os = new OperatingSystem;
        $historyType = null;
        if (isset($config['history'])) {
            $historyType = $config['history'];
        }
        switch ($historyType) {
            case 'step':
                $history = new StepHistory;
                break;
            default:
                $history = new ConsecutiveHistory;
        }
        $this->variables = new VariablesManager($history, $this->interpreter);
        $this->variables->initialize();
    }

    /**
     * Getter for gaining access to inner variables.
     *
     * @param string $name Property name.
     *
     * @return Interpreter|BasicInterface|CommandLineInterface|VariablesManager
     * @since 0.1.0
     */
    public function __get($name)
    {
        switch ($name) {
            case 'os':
                return $this->os;
            case 'shell':
                return $this->os->getShell();
            case 'variables':
                return $this->variables;
            case 'interpreter':
                return $this->interpreter;
            default:
                $message = sprintf('Unknown property `%s`', $name);
                throw new BadMethodCallException($message);
        }
    }
}
