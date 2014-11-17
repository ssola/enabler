<?php namespace Enabler\Filter;

use Enabler\Feature;
use Enabler\Identity;
use Enabler\Filter\Algorithm\RandomWeighted;

/**
 * Using given algorithm tries to validates if visitor can see given Feature or not
 * 
 * @package Enabler\Filter
 */
class Distributed implements Filterable
{
    /**
     * Stores algorithm to use in order to calculate distribution
     * 
     * @see Enabler\Filter\Algorithm\RandomWeighted
     */
    private $algorithm;

    /**
     * @see Enabler\Filter\Filterable filter
     */
    public function filter ($data, Feature $feature, Identity $identity)
    {
        $percentage = $data;
        $persistence = $this->getCookie();

        if(!empty($persistence)) {
            if(isset($persistence[$feature->name])) {
                return $persistence[$feature->name];
            }
        }

        if($percentage > 100) {
            throw new \InvalidArgumentException("Percentage should not be greater than 100");
        }

        $this->loadAlgorithm([
            'display' => intval($percentage),
            'hide' => intval(abs(100-$percentage))
        ]);

        $result = $this->algorithm->calculate();

        $storedResult = false;
        if($result == "display") {
            $storedResult = true;
        }
        
        $persistence[$feature->name] = $storedResult;

        $this->storeCookie($persistence);

        return $result;
    }

    /**
     * Get information for cookie
     */
    protected function getCookie()
    {
        if(php_sapi_name() == 'cli') {
            return null;
        }

        return (isset($_COOKIE['__enabler_persistence']) ? json_decode($_COOKIE['__enabler_persistence']) : []);
    }

    /**
     * Stores persistence array data to a cookie in order to remember this visitor
     * 
     * @param array $persistence
     */
    protected function storeCookie($persistence) 
    {
        if(php_sapi_name() == 'cli') {
            return null;
        }

        setcookie("__enabler_persistence", json_encode($persistence), time() + (3600*24*30));
    }

    /**
     * Load default algorithm with given data
     * 
     * @param array $data
     */
    protected function loadAlgorithm($data)
    {
        if(empty($this->algorithm)) {
            return $this->algorithm = new RandomWeighted($data);    
        }
        
        return $this->algorithm;
    }

    /**
     * Call this method if you want to inject your own algorithm
     * 
     * @param object $algorithm
     */
    public function addAlgorithm($algorithm) 
    {
        $this->algorithm = $algorithm;
    }
}