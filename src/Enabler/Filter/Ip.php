<?php namespace Enabler\Filter;

use Enabler\Feature;
use Enabler\Identity;

class Ip implements Filterable
{
    public function filter($value, Feature $feature, Identity $identity) 
    {
        $ips = $value;

        if(!is_array($value)) {
            $ips = [];
            $ips[] = $value;
        }

        if(in_array($this->getIp(), $ips)) {
            return true;
        }

        return false;
    }

    private function getIp()
    {
        return $_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);
    }
}