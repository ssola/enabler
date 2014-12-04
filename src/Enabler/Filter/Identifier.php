<?php namespace Enabler\Filter;

use Enabler\Feature;
use Enabler\Identity;

/**
 * This filter tries to filter with user information at the moment it
 * supports user id and/or group
 * 
 * @package Enabler\Filter
 */
class Identifier implements Filterable
{
    /**
     * @see Enabler\Filter\Filterable filter
     */
    public function filter (array $data, Feature $feature, Identity $identity)
    {
        if(!isset($data['userIds']) && !isset($data['groups'])) {
            throw new \InvalidArgumentException("Missing user ids or groups");
        }

        if ($this->guardItem('userIds', $data, $identity)
            || $this->guardItem('groups', $data, $identity)) {
            return true;
        }

        return false;
    }

    /**
     * Validates if current Identity can see this feature
     * 
     * @param string $name
     * @param array $values
     * @param Identity $identity
     */
    protected function guardItem($name, $values, Identity $identity)
    {
        $singularName = ucfirst(substr($name, 0, strlen($name) - 1));
        $hasMethod = sprintf("has%s", $singularName);
        $getMethod = sprintf("get%s", $singularName);

        if (!$identity->$hasMethod() || !isset($values[$name])) {
            return false;
        }

        foreach ($values[$name] as $item) {
            if($item == $identity->$getMethod()) {
                return true;
            }
        }

        return false;
    }
}