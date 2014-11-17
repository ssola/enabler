<?php namespace Enabler;

use Enabler\Storage\Storable;
use Enabler\Filter\Factory as FilterFactory;

/**
 * Enabler main class
 * 
 * @package Enabler
 */
class Enabler
{
    /**
     * Has the storage system used to store features
     * 
     * @var Storage\Storable
     */
    private $storage;

    /**
     * Has the identity class in order to retrieve user id and group
     * 
     * @var Identity
     */
    private $identity;

    /**
     * Has the filter factory to retrieve and load the necessary filters
     * 
     * @var Filter\Factory
     */
    private $filterRepository;

    /**
     * Constructor expects and storage object and an optional identity object
     * 
     * @param Storage\Storable $storage
     * @param Identity $identity
     */
    public function __construct(Storable $storage, Identity $identity = null)
    {
        $this->storage = $storage;
        $this->identity = $identity;
        $this->filterRepository = new FilterFactory();

        if($identity == null) {
            $this->identity = new Identity;
        }
    }

    /**
     * Returns storage provider
     * 
     * @return Storage\Storable
     */
    public function storage()
    {
        return $this->storage;
    }

    /**
     * Given a feature name checks if filters are correct for current session / identity
     * 
     * @param string $featureName
     * @return bool
     */
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