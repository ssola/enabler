<?php namespace Enabler;

/**
 * This class is used to represent a feature. This class expects if this
 * feature is enabled and which filters should be used to determinate if
 * an user can see or not your feature.
 * 
 * @package Enabler
 */
class Feature
{
    /**
     * Here you can define your feature name
     * 
     * @var string $name
     */
    private $name;

    /**
     * Define all the filters should be processed
     * 
     * @var array $filters;
     */
    private $filters;

    /**
     * This flag is to know if this feature is currently enabled to everyone or not
     * 
     * @var bool $enabled
     */
    private $enabled;

    /**
     * Builing a new feature expects the basic Feature information.
     * 
     * @param string $name
     * @param bool $enabled
     * @param array $filters
     */
    public function __construct($name, $enabled, $filters = [] )
    {
        if(empty($name) || empty($filters) || empty($enabled)) {
            throw new \InvalidArgumentException("Some of the parameters are empty"); 
        }

        $this->name = $name;
        $this->enabled = $enabled;

        if(count($filters) > 0) {
            foreach($filters as $filter => $value) {
                if(!class_exists($filter)) {
                    throw new \InvalidArgumentException("Validator not valid!");
                }

                $this->filters[$filter] = $value;
            }
        }
    }

    /**
     * Magic method to access to feature properties
     * 
     * @param string $property
     * @return mixed
     */
    public function __get($property)
    {
        if(!property_exists($this, $property)) {
            throw new \Exception("Propery $property doesn't exists");
        }

        return $this->{$property};
    }
}