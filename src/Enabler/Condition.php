<?php namespace Enabler;

use Enabler\Filter\Filterable;

class Condition
{
    protected $filter;
    protected $depends;

    public function addFilter(Filterable $filter)
    {
        $this->filter = $filter;
    }

    public function addDependencies(array $depends)
    {
        if(empty($depends)) {
            return false;
        }

        foreach($depends as $dependency) {
            if(!$dependency instanceof Filterable) {
                throw new \InvalidArgumentException("Dependecy $dependency is not valid");
            }

            $this->depends[] = $dependency;
        }
    }
}