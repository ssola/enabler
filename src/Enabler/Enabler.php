<?php namespace Enabler;

use Enabler\Storage\Storable;

class Enabler
{
    private $storage;

    public function __construct(Storable $storage)
    {
        $this->storage = $storage;
    }

    public function storage()
    {
        return $this->storage;
    }

    public function enabled($featureName)
    {
        $feature = $this->storage()->get($featureName);

        // If record doesn't exists, then we should enable this feature
        if(empty($feature)) {
            return true;
        }

        // if feature has been enabled then it's open to everyone
        if(!$feature->enabled) {
            return true;
        }

        if(!is_array($feature->filters)) {
            return true;
        }

        foreach($feature->filters as $filter => $value) {
            if(!class_exists($filter)) {
                throw new \RuntimeException("Validator not found!");
            }

            $instance = new $filter();
            if(!$instance->filter($value, $feature)) {
                return false;
            }
        }

        return true;
    }
}