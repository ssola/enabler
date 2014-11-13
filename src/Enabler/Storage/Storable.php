<?php namespace Enabler\Storage;

use Enabler\Feature;

interface Storable
{
    public function create(Feature $feature);
    public function delete();
    public function get($name);
}