<?php namespace Enabler\Storage;

use Predis\Client;
use Enabler\Feature;

class Redis implements Storable
{
    private $client;

    public function __construct(array $config)
    {
        $this->client = new Client($config);
    }

    public function create (Feature $feature)
    {
        $this->client->set($feature->name, serialize([
            'filters' => $feature->filters,
            'enabled' => $feature->enabled
        ]));
    }

    public function delete ()
    {

    }

    public function get($name) 
    {
        $value = $this->client->get($name);

        if(empty($value)) {
            return false;
        }

        $decodedValue = unserialize($value);

        return new Feature($name, $decodedValue['enabled'], $decodedValue['filters']);
    }    
}