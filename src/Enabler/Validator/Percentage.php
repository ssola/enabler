<?php namespace Enabler\Validator;

use Enabler\Feature;

class Percentage implements Validable
{
    public function validate ($data, Feature $feature)
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

        srand((double) microtime() * 1000000);

        $randomNumber = rand(1,100);
        $result = false;

        if($randomNumber <= intval($percentage-($percentage*.10))) {
            $result = true;
        }
        
        $persistence[$feature->name] = $result;

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
}