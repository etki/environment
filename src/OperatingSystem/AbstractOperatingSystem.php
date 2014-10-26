<?php

namespace Etki\Environment\OperatingSystem;

use BadMethodCallException;
use Etki\Environment\OperatingSystem\Interfaces\BasicInterface;

/**
 *
 *
 * @version 0.1.0
 * @since   
 * @package Etki\Environment\OperatingSystem
 * @author  Etki <etki@etki.name>
 */
class AbstractOperatingSystem implements BasicInterface
{
    protected $familyBranch = array();
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
    protected function initFamily($family)
    {
        $branch = $this->familyWalker($this->familyHierarchy, $family);
        if (!$branch) {
            $message = sprintf('Couldn\'t find OS family `%s`', $family);
            throw new BadMethodCallException($message);
        }
        $this->familyBranch = $branch;
    }
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
    public function belongsTo($family)
    {
        return in_array($family, $this->familyBranch);
    }
}
