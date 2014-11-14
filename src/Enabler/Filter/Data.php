<?php namespace Enabler\Filter;

use Enabler\Feature;

class Data implements Filterable
{
    public function filter ($data, Feature $feature)
    {
        if(!is_array($data)) {
            throw new \InvalidArgumentException("Input data is wrong");
        }

        foreach($data as $value => $possibleValues) {
            if(!is_array($possibleValues)) {
                continue;
            }

            if(in_array($value, $possibleValues)) {
                return true;
            }
        }

        return false;
    }
}