<?php

namespace Etki\Environment\OperatingSystem\Interfaces;

use Etki\Environment\OperatingSystem\User\AbstractUser;
use Etki\Environment\OperatingSystem\Shell\CommandLineInterface;

/**
 * Basic operating system interface.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\OperatingSystem
 * @author  Etki <etki@etki.name>
 */
interface BasicOsInterface
{
    /**
     * Constant that represents Windows OS family.
     *
     * @type string
     * @since 0.1.0
     */
    const FAMILY_WINDOWS = 'windows';

    /**
     * Constant that represents  OS family.
     *
     * @type string
     * @since 0.1.0
     */
    const FAMILY_UNIX = 'unix';

    /**
     * Constant that represents  OS family.
     *
     * @type string
     * @since 0.1.0
     */
    const FAMILY_DEBIAN = 'debian';

    /**
     * Constant that represents Ubuntu OS family.
     *
     * @type string
     * @since 0.1.0
     */
    const FAMILY_UBUNTU = 'ubuntu';

    /**
     * Constant that represents Slackware OS family.
     *
     * @type string
     * @since 0.1.0
     */
    const FAMILY_SLACKWARE = 'slackware';

    /**
     * Constant that represents Suse OS family.
     *
     * @type string
     * @since 0.1.0
     */
    const FAMILY_SUSE = 'suse';

    /**
     * Constant that represents BSD OS family.
     *
     * @type string
     * @since 0.1.0
     */
    const FAMILY_BSD = 'bsd';

    /**
     * Constant that represents FreeBSD OS family.
     *
     * @type string
     * @since 0.1.0
     */
    const FAMILY_FREEBSD = 'freebsd';

    /**
     * Constant that represents Mac OS family.
     *
     * @type string
     * @since 0.1.0
     */
    const FAMILY_MAC = 'mac';

    /**
     * Retrieves CLI.
     *
     * @return CommandLineInterface
     * @since 0.1.0
     */
    public function getShell();

    /**
     * Returns class with basic filesystem functionality. Returned object
     * doesn't have any references to Symfony Filesystem component.
     *
     * @return mixed
     * @since 0.1.0
     */
    public function getFilesystem();

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
     * @return AbstractUser
     * @since 0.1.0
     */
    public function getUser();
}
