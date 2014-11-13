<?php namespace Enabler;

use Enabler\Validator\Validable;

class Feature
{
    private $name;
    private $validators;
    private $enabled;

    public function __construct($name, $enabled, $validators = [] )
    {
        if(empty($name) || empty($validators) || empty($enabled)) {
            throw new \InvalidArgumentException("Some of the parameters are empty"); 
        }

        $this->name = $name;
        $this->enabled = $enabled;

        if(count($validators) > 0) {
            foreach($validators as $validator => $value) {
                if(!class_exists($validator)) {
                    throw new \InvalidArgumentException("Validator not valid!");
                }

                $this->validators[$validator] = $value;
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