<?php namespace Enabler\Filter;

/**
 * This class handles the process to load and store Filterable instances.
 * 
 * @package Enabler\Filter;
 */
class Factory
{
    /**
     * Stores all the loaded filters in a static array
     * 
     * @var array $filterRepository;
     */
    private static $filterRepository = [];

    /**
     * Given a filter class name tries to load it and store it to the loaded repository.
     * 
     * @param string $filter
     * @return Enabler\Filter\Filterable
     */
    public function load ($filter) 
    {
        if(!class_exists($filter)) {
            throw new \RuntimeException(sprintf("Filter %s not found!", $filter));
        }

        if(!isset(self::$filterRepository[$filter])) {
            self::$filterRepository[$filter] = new $filter;
        }

        return self::$filterRepository[$filter];
    }
}