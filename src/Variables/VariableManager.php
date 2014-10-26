<?php

namespace Etki\Environment\Variables;

use BadMethodCallException;

/**
 * Manages environmental variables.
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
class VariableManager
{
    /**
     * Saved snapshots.
     *
     * @type array
     * @since 0.1.0
     */
    protected $history = array();
    /**
     * Global variables wrappers.
     *
     * @type VariableStorage[]
     * @since 0.1.0
     */
    protected $storage = array();
    /**
     * Cursor pointing to current history element.
     *
     * @type int
     * @since 0.1.0
     */
    protected $historyCursor = 0;

    /**
     * Constant for restoring particular state by going down from current one.
     *
     * @type string
     * @since 0.1.0
     */
    const RESTORE_DIRECTION_DOWN = 1;
    /**
     * Constant for restoring particular state by going down from initial one.
     *
     * @type string
     * @since 0.1.0
     */
    const RESTORE_DIRECTION_UP = 2;
    /**
     * Constant for automatic selection of restore strategy.
     *
     * @type string
     * @since 0.1.0
     */
    const RESTORE_DIRECTION_AUTO = 3;

    /**
     * Initializer.
     *
     * @return self
     * @since 0.1.0
     */
    public function __construct()
    {
        $keys = array('get', 'post', 'cookie', 'session', 'server', 'env');
        foreach ($keys as $globalVarName) {
            if ($globalVarName === 'session' && !$this->sessionEnabled()) {
                continue;
            }
            $globalVarName = '_' . strtoupper($globalVarName);
            if (!isset(${$globalVarName})) {
                continue;
            }
            $source = ${$globalVarName};
            foreach ($source as $key => $value) {

            }
        }
    }

    /**
     * Sets environment state.
     *
     * @param array $data           Data to set.
     * @param bool  $createSnapshot Whether to create snapshot or merge with
     *                              current.
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
    }

    /**
     * Resets environment state.
     *
     * @param bool $hard If set to true, environment will be simply truncated,
     *                   and no initial state recovery will be performed.
     *
     * @return void
     * @since 0.1.0
     */
    public function reset($hard = false)
    {
    }

    /**
     * Creates a snapshot.
     *
     * @return int Snapshot id.
     * @since 0.1.0
     */
    public function snapshot()
    {
        return $this->historyCursor++;
    }

    /**
     * Restores previously saved snapshot.
     *
     * @param null $id
     *
     * @return void
     * @since 0.1.0
     */
    public function restore(
        $id = null,
        $direction = self::RESTORE_DIRECTION_AUTO
    ) {
        if ($direction === self::RESTORE_DIRECTION_AUTO) {
            $direction = self::RESTORE_DIRECTION_DOWN;
            if ($id < $this->historyCursor / 2) {
                $direction = self::RESTORE_DIRECTION_UP;
            }
        }
    }
    public function getHeader($name, $default = null)
    {
        $name = strtoupper(str_replace('-', '_', $name));
        return $this->getServerParameter('HTTP_' . $name, $default);
    }
    public function getRequestParameter($key, $default = null)
    {

    }
    public function getCookieParameter($key, $default)
    {

    }
    public function getServerParameter($key, $default)
    {

    }
    public function getPostParameter($key, $default = null)
    {

    }
    public function getQueryParameter($key, $default = null)
    {

    }
    public function getEnvParameter($key, $default = null)
    {

    }
    protected function getParameter($key, $storage, $default)
    {

    }
    protected function setParameter($key, $storage, $value)
    {

    }
    protected function unsetParameter($key, $storage)
    {

    }
    protected function sessionEnabled()
    {
        return (bool) session_id();
    }
    protected function deleteParameter($key, $storageKey)
    {
        $storage = $this->storage[$storageKey];
        if (!$storage->has($key)) {
            throw new BadMethodCallException('Key `%s` doesn\'t exis');
        }
    }
}
