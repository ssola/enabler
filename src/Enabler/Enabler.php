<?php namespace Enabler;

use Enabler\Storage\Storable;
use Enabler\Filter\Factory as FilterFactory;

class Enabler
{
    private $storage;
    private $identity;
    private $filterRepository;

    public function __construct(Storable $storage, Identity $identity = null)
    {
        $this->storage = $storage;
        $this->identity = $identity;
        $this->filterRepository = new FilterFactory();

        if($identity == null) {
            $this->identity = new Identity;
        }
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
            $instance = $this->filterRepository->load($filter);

            if(!$instance->filter($value, $feature, $this->identity)) {
                return false;
            }
        }

        return true;
    }
}