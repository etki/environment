<?php

namespace Etki\Environment\Variables;

use BadMethodCallException;
use Etki\Environment\Environment;
use Etki\Environment\Interpreter\Interpreter;
use Etki\Environment\Variables\History\HistoryInterface;

/**
 * Manages environmental variables.
 *
 * Sorry, guys with no-phpdoc-support IDEs. Time to get modern.
 *
 * @method void  setQueryParameter(string $parameter, mixed $value)
 * @method mixed getQueryParameter(string $parameter, mixed $defaultValue)
 * @method bool  hasQueryParameter(string $parameter)
 * @method void  unsetQueryParameter(string $parameter)
 * @method void  setPostParameter(string $parameter, mixed $value)
 * @method mixed getPostParameter(string $parameter, mixed $defaultValue)
 * @method bool  hasPostParameter(string $parameter)
 * @method void  unsetPostParameter(string $parameter)
 * @method void  setCookieParameter(string $parameter, mixed $value)
 * @method mixed getCookieParameter(string $parameter, mixed $defaultValue)
 * @method bool  hasCookieParameter(string $parameter)
 * @method void  unsetCookieParameter(string $parameter)
 * @method void  setSessionParameter(string $parameter, mixed $value)
 * @method mixed getSessionParameter(string $parameter, mixed $defaultValue)
 * @method bool  hasSessionParameter(string $parameter)
 * @method void  unsetSessionParameter(string $parameter)
 * @method void  setEnvParameter(string $parameter, mixed $value)
 * @method mixed getEnvParameter(string $parameter, mixed $defaultValue)
 * @method bool  hasEnvParameter(string $parameter)
 * @method void  unsetEnvParameter(string $parameter)
 * @method void  setServerParameter(string $parameter, mixed $value)
 * @method mixed getServerParameter(string $parameter, mixed $defaultValue)
 * @method bool  hasServerParameter(string $parameter)
 * @method void  unsetServerParameter(string $parameter)
 * @method void  setRuntimeParameter(string $parameter, mixed $value)
 * @method mixed getRuntimeParameter(string $parameter, mixed $defaultValue)
 * @method bool  hasRuntimeParameter(string $parameter)
 * @method void  unsetRuntimeParameter(string $parameter)
 *
 * @SuppressWarnings(PHPMD.Superglobals)
 *
 * @todo
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\Variables
 * @author  Etki <etki@etki.name>
 */
class Manager
{
    /**
     * Saved snapshots.
     *
     * @type HistoryInterface
     * @since 0.1.0
     */
    protected $history;
    /**
     * Global variables wrappers.
     *
     * @type Storage[]
     * @since 0.1.0
     */
    protected $storage = array();

    /**
     * Initializer.
     *
     * @return self
     * @since 0.1.0
     */
    public function __construct(
        HistoryInterface $history,
        Interpreter $interpreter
    ) {
        $this->history = $history;
        $this->interpreter = $interpreter;
    }

    /**
     * Initializes manager.
     *
     * @return void
     * @since 0.1.0
     */
    public function initialize()
    {
        $keys = array('get', 'post', 'cookie', 'session', 'server', 'env');
        foreach ($keys as $globalVar) {
            if ($globalVar === 'session'
                && !$this->interpreter->isSessionEnabled()
            ) {
                continue;
            }
            $globalVarName = '_' . strtoupper($globalVar);
            if (!isset($GLOBALS[$globalVarName])) {
                continue;
            }
            $source = $GLOBALS[$globalVarName];
            $this->storage[$globalVar] = new Storage($source, $globalVar);
            foreach ($source as $key => $value) {
                $this->setParameter($globalVar, $key, $value);
            }
        }
        $this->history->snapshot();
    }

    /**
     * Sets environment state.
     *
     * @param array $data           Data to set.
     * @param bool  $createSnapshot Whether to create snapshot or merge with
     *                              current staging changes.
     *
     * @return void
     * @since 0.1.0
     */
    public function setState(
        array $data,
        $createSnapshot = true
    ) {
        if ($createSnapshot) {
            $this->snapshot();
        }
        foreach ($data as $key => $value) {
            if (isset($this->storage[$key])) {
                //$this->storage[$key]->
            }
        }
    }

    /**
     * Resets environment state.
     *
     * @param bool $hard If set to true, environment will be simply truncated,
     *                   and no initial state recovery will be performed. Only
     *                   $_SERVER variable will be left untouched.
     *
     * @return void
     * @since 0.1.0
     */
    public function reset($hard = false)
    {
        if ($hard) {
            foreach ($this->storage as $key => $value) {
                if ($key === 'server') {
                    continue;
                }
                $value->truncate();
            }
        }
    }
    protected function loadDiff(array $diff)
    {
        foreach ($diff as $action) {

        }
    }

    /**
     * Creates a snapshot.
     *
     * @param bool $analyze If set to true, the diff will be calculated
     *                      automatically.
     *
     * @return int Snapshot ID.
     * @since 0.1.0
     */
    public function snapshot($analyze = false)
    {
        return $this->history->snapshot();
    }

    /**
     * Restores previously saved snapshot.
     *
     * @param int $snapshot Snapshot ID. If omitted, last snapshot will be used.
     *
     * @return void
     * @since 0.1.0
     */
    public function restore($snapshot = null)
    {
        if ($snapshot === null) {
            $snapshot = $this->history->getCurrentSnapshot();
        }
        $diff = $this->history->moveToSnapshot($snapshot);
        $this->loadDiff($diff);
    }

    /**
     * Magic method that provides all [action][Storage]Parameter methods.
     *
     * @param       $method
     * @param array $args
     *
     * @return mixed
     * @since
     */
    public function __call($method, array $args)
    {
        $pattern = '~^(get|set|unset|has)(\w+)Parameter$~';
        if (!preg_match($pattern, $method, $matches)) {
            $message = sprintf('Unknown method `%s`', $method);
            throw new BadMethodCallException($message);
        }
        $storage = $this->getStorageKey($matches[2]);
        array_unshift($args, $storage);
        $callable = array($this, $matches[1] . 'Parameter');
        return call_user_func_array($callable, $args);
    }

    /**
     * Retrieves parameter by it's name and storage ID (if it exists).
     *
     * @param string $storage Storage ID (get, post, etc.).
     * @param string $key     Item key.
     * @param mixed  $default Parameter value to return if it doesn't exist.
     *
     * @return mixed Parameter value or `$default`.
     * @since 0.1.0
     */
    protected function getParameter($storage, $key, $default = null)
    {
        $storage = $this->getStorage($storage);
        if (!$storage->has($key)) {
            return $default;
        }
        return $storage->get($key);
    }

    /**
     * Sets storage parameter.
     *
     * @param string $storage Storage ID (get, post, etc.).
     * @param string $key     Item key.
     * @param mixed  $value   Item value.
     *
     * @return void
     * @since 0.1.0
     */
    protected function setParameter($storage, $key, $value)
    {
        $storage = $this->getStorage($storage);
        if ($storage->has($key)) {
            $data = array($storage->get($key), $value);
            $this->history->pushAction('modify', $storage, $key, $data);
        } else {
            $this->history->pushAction('set', $storage, $key, $value);
        }
        $storage->set($key, $value);

    }

    /**
     * Tells if storage has parameter.
     *
     * @param string $storage Storage ID (get, post, etc.).
     * @param string $key     Item key.
     *
     * @return bool
     * @since 0.1.0
     */
    protected function hasParameter($storage, $key)
    {
        return $this->getStorage($storage)->has($key);
    }

    /**
     * Removes parameter from storage.
     *
     * @param string $storage Storage ID (get, post, etc.).
     * @param string $key     Item key.
     *
     * @return void
     * @since 0.1.0
     */
    protected function unsetParameter($storage, $key)
    {
        $storage = $this->getStorage($storage);
        if ($storage->has($key)) {
            $item = $storage->get($key);
            $storage->delete($key);
            $this->history->pushAction('delete', $storage, $key, $item);
        }
    }

    /**
     * Retrieves storage by it's key.
     *
     * @param string $key
     *
     * @throws BadMethodCallException Thrown if unknown storage is requested.
     *
     * @inline
     *
     * @return Storage Requested storage.
     * @since 0.1.0
     */
    protected function getStorage($key)
    {
        if (!isset($this->storage[$key])) {
            $message = sprintf('Unknown storage `%s`', $key);
            throw new BadMethodCallException($message);
        }
        return $this->storage[$key];
    }

    /**
     * Retrieves storage key by name.
     *
     * @param string $rawStorageName Raw storage name.
     *
     * @return string Storage key.
     * @since 0.1.0
     */
    protected function getStorageKey($rawStorageName)
    {
        $storageName = strtolower($rawStorageName);
        switch ($storageName) {
            case 'environment':
                return 'env';
            case 'query':
                return 'get';
            default:
                return $storageName;
        }
    }

    /**
     * Retrieves request header.
     *
     * @param      $name
     * @param null $default
     *
     * @return mixed
     * @since
     */
    public function getRequestHeader($name, $default = null)
    {
        $name = strtoupper(str_replace('-', '_', $name));
        return $this->getServerParameter('HTTP_' . $name, $default);
    }
}
