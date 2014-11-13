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

        if(!is_array($feature->validators)) {
            return true;
        }

        foreach($feature->validators as $validator => $value) {
            if(!class_exists($validator)) {
                throw new \RuntimeException("Validator not found!");
            }

            $instance = new $validator();
            if(!$instance->validate($value, $feature)) {
                return false;
            }
        }

        return true;
    }
}