<?php namespace Enabler\Filter;

class Factory
{
    private static $filterRepository = [];

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