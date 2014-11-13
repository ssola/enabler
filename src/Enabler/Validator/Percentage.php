<?php namespace Enabler\Validator;

use Enabler\Feature;

class Percentage implements Validable
{
    public function validate ($data, Feature $feature)
    {
        $percentage = $data;
        $persistence = (isset($_COOKIE['__enabler_persistence']) ? json_decode($_COOKIE['__enabler_persistence']) : []);

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

        if($randomNumber <= $percentage) {
            $result = true;
        }
        
        $persistence[$feature->name] = $result;

        setcookie("__enabler_persistence", json_encode($persistence), time() + (3600*24*30));
    }
}