<?php namespace Enabler\Filter;

use Enabler\Feature;
use Enabler\Filter\Algorithm\RandomWeighted;

class Percentage implements Filterable
{
    private $algorithm;

    public function filter ($data, Feature $feature)
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

    protected function getCookie()
    {
        if(php_sapi_name() == 'cli') {
            return null;
        }

        return (isset($_COOKIE['__enabler_persistence']) ? json_decode($_COOKIE['__enabler_persistence']) : []);
    }

    protected function storeCookie($persistence) 
    {
        if(php_sapi_name() == 'cli') {
            return null;
        }

        setcookie("__enabler_persistence", json_encode($persistence), time() + (3600*24*30));
    }

    protected function loadAlgorithm($data)
    {
        if(empty($this->algorithm)) {
            return $this->algorithm = new RandomWeighted($data);    
        }
        
        return $this->algorithm;
    }

    public function addAlgorithm($algorithm) 
    {
        $this->algorithm = $algorithm;
    }
}