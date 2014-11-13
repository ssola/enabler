<?php namespace Enabler\Validator;

use Enabler\Feature;

class Ip implements Validable
{
    public function validate($value, Feature $feature) 
    {
        $ips = $value;

        if(!is_array($value)) {
            $ips[] = $value;
        }

        if(in_array($this->getIp(), $ips)) {
            return true;
        }

        return false;
    }

    private function getIp()
    {
        if (php_sapi_name() === 'cli') {
            return null;
        }

        return $_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);
    }
}