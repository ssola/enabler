<?php namespace Enabler\Filter;

use Enabler\Feature;
use Enabler\Identity;

/**
 * This interface represents a filter. Given the feature data and Identity each
 * filter will return true/false if filter was passed successfully or not.
 * 
 * @package Enabler\Filter
 */
interface Filterable
{
    /**
     * Given a value, Feature and an Identity checks if should be visibel or not
     * 
     * @param mixed $value
     * @param Feature $feature
     * @param Identity $identity
     */
    public function filter(array $value, Feature $feature, Identity $identity);
}