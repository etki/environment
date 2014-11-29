<?php

namespace Etki\Environment\OperatingSystem\User;

use Etki\Environment\Exception\NotImplementedException;
use Etki\Environment\OperatingSystem\Interfaces\BasicOsInterface;

/**
 * This class describes OS user.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\OperatingSystem\User
 * @author  Etki <etki@etki.name>
 */
abstract class AbstractUser implements UserInterface
{
    /**
     * Current operating system.
     *
     * @type BasicOsInterface
     * @since 0.1.0
     */
    protected $operatingSystem;
    /**
     * User login.
     *
     * @type string
     * @since 0.1.0
     */
    protected $login;
    /**
     * Caches the value of this user being superuser.
     *
     * @type bool
     * @since 0.1.0
     */
    protected $isSuperuser;

    /**
     * Sets operating system.
     *
     * @param BasicOsInterface $operatingSystem Current operating system.
     *
     * @return void
     * @since 0.1.0
     */
    public function setOs(BasicOsInterface $operatingSystem)
    {
        $this->operatingSystem = $operatingSystem;
    }
    /**
     * Verifies that current user has super-abilities.
     *
     * @todo
     *
     * @return void
     * @since 0.1.0
     */
    public function isSuperuser()
    {
        throw new NotImplementedException;
    }
}
