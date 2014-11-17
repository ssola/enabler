<?php namespace Enabler\Filter;

use Enabler\Feature;
use Enabler\Identity;

interface Filterable
{
    public function filter($value, Feature $feature, Identity $identity);
}