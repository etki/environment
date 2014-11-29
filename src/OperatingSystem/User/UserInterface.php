<?php

namespace Etki\Environment\OperatingSystem\User;

/**
 * Thi interface describes single user, not necessary the one current process is
 * executed by.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\OperatingSystem\User
 * @author  Etki <etki@etki.name>
 */
interface UserInterface
{
    /**
     * Tells if current user has superuser access
     *
     * @return bool
     * @since 0.1.0
     */
    public function isSuperuser();

    /**
     * Tells if user has write access to target.
     *
     * @param string $target Path to target directory/file.
     *
     * @return bool
     * @since 0.1.0
     */
    public function hasWriteAccess($target);

    /**
     * Tells if user has read access to target.
     *
     * @param string $target Path to target directory/file.
     *
     * @return bool
     * @since 0.1.0
     */
    public function hasReadAccess($target);
    /**
     * Tells if user can execute target file.
     *
     * @param string $target Path to target /file.
     *
     * @return bool
     * @since 0.1.0
     */
    public function hasExecuteAccess($target);
}
