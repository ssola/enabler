<?php namespace Enabler\Filter;

use Enabler\Feature;
use Enabler\Identity;

/**
 * Try to check if IP exists in an IPs array or if it belongs to a given IP range
 * 
 * @package Enabler\Filter
 */
class Ip implements Filterable
{
    /**
     * @see Enabler\Filter\Filterable filter
     */
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

    /**
     * Get user IP
     * 
     * @return mixed
     */
    private function getIp()
    {
        return $_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);
    }
}