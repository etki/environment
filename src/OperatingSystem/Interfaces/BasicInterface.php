<?php

namespace Etki\Environment\OperatingSystem\Interfaces;

use Etki\Environment\OperatingSystem\User\User;

/**
 * Basic operating system interface.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\OperatingSystem
 * @author  Etki <etki@etki.name>
 */
interface BasicInterface
{
    /**
     * Retrieves CLI.
     *
     * @return
     * @since 0.1.0
     */
    public function getShell();

    /**
     * retrieves OS version.
     *
     * @return string
     * @since 0.1.0
     */
    public function getVersion();

    /**
     * Gets OS family.
     *
     * @return string
     * @since 0.1.0
     */
    public function getFamily();

    /**
     * Return family hierarchy branch up to root node.
     *
     * @return string
     * @since 0.1.0
     */
    public function getFamilyHierarchy();

    /**
     * Tells if OS belongs to particular family.
     *
     * @param string $family Family to inspect for children like provided.
     *
     * @return bool
     * @since 0.1.0
     */
    public function belongsTo($family);

    /**
     * Return user.
     *
     * @return User
     * @since 0.1.0
     */
    public function getUser();
}
