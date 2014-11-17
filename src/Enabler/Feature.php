<?php namespace Enabler;

use Enabler\Condition;
use Enabler\Validator\Validable;

class Feature
{
    private $name;
    private $filters;
    private $enabled;

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

    public function __get($property)
    {
        if(!property_exists($this, $property)) {
            throw new \Exception("Propery $property doesn't exists");
        }

        return $this->{$property};
    }
}