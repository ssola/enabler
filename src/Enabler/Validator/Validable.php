<?php namespace Enabler\Validator;

use Enabler\Feature;

interface Validable
{
    public function validate($value, Feature $feature);
}