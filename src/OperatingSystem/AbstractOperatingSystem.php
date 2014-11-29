<?php

namespace Etki\Environment\OperatingSystem;

use BadMethodCallException;
use Etki\Environment\OperatingSystem\Interfaces\BasicOsInterface;

/**
 * Abstract class with basic functionality required by concrete operating
 * system.
 *
 * @version 0.1.0
 * @since   0.1.0
 * @package Etki\Environment\OperatingSystem
 * @author  Etki <etki@etki.name>
 */
abstract class AbstractOperatingSystem implements BasicOsInterface
{
    /**
     * Current OS family and it's ancestors.
     *
     * @type string[]
     * @since 0.1.0
     */
    protected $familyBranch = array();
    /**
     * OS family hierarchy.
     *
     * @type array
     * @since 0.1.0
     */
    protected $familyHierarchy = array(
        'unix' => array(
            'debian' => array(
                'ubuntu',
            ),
            'slackware' => array(
                'suse',
            ),
            'bsd' => array(
                'freebsd',
                'mac',
            ),
        ),
        'windows',
    );

    /**
     * Returns pattern for running command as background job.
     *
     * @return string
     * @since 0.1.0
     */
    public function getBackgroundProcessPattern()
    {
        if ($this->belongsTo(self::FAMILY_WINDOWS)) {
            return 'START /B %s';
        }
        return '%s &';
    }

    /**
     * Initializes os family hierarchy using provided family name.
     *
     * @param string $family OS family.
     *
     * @return void
     * @since 0.1.0
     */
    protected function initFamily($family)
    {
        $branch = $this->familyWalker($this->familyHierarchy, $family);
        if (!$branch) {
            $message = sprintf('Couldn\'t find OS family `%s`', $family);
            throw new BadMethodCallException($message);
        }
        $this->familyBranch = $branch;
    }

    /**
     * Walks through the OS family tree and returns family hierarchy.
     *
     * @param array  $tree   OS family tree.
     * @param string $needle OS to look for.
     *
     * @return string[]|false OS family with all ancestors or false if family
     *                        hasn't been found.
     * @since 0.1.0
     */
    protected function familyWalker($tree, $needle)
    {
        foreach ($tree as $key => $value) {
            if ($value === $needle) {
                return array($value);
            } elseif (is_array($value)
                && $result = $this->familyWalker($value, $needle)
            ) {
                return array_merge(array($key), $result);
            }
        }
        return false;
    }

    /**
     * Tells if current OS belongs to provided family.
     *
     * @param string $family
     *
     * @return bool
     * @since 0.1.0
     */
    public function belongsTo($family)
    {
        return in_array($family, $this->familyBranch);
    }
}
