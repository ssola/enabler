<?php namespace Enabler\Filter;

use Enabler\Feature;

interface Filterable
{
    public function filter($value, Feature $feature);
}