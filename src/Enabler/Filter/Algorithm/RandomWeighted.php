<?php namespace Enabler\Filter\Algorithm;

/**
 * This is a Weighted Random Distribution algorithm in order to know
 * if a Feature should be displayed to a certain user. We are using a
 * In-place (unsorted) algorithm.
 * 
 * @package Enabler\Filter\Algorithm
 */
class RandomWeighted
{
    /**
     * Stores an array with the weighted values
     * 
     * @var array
     */
    private $weightedValues = [];

    /**
     * Constructor expects an array with weighted values to do some calculations
     * 
     * @param array $weightedValues
     */
    public function __construct(array $weightedValues)
    {
        if(empty($weightedValues)) {
            throw new \InvalidArgumentException("We need a non empty weighted values array");
        }

        $this->weightedValues = $weightedValues;
    }

    /**
     * Returns an integer from 1 to sum of all weighted values
     * 
     * @return int
     */
    public function calculate()
    {
        $rand = mt_rand(1, (int) array_sum($this->weightedValues));

        foreach ($this->weightedValues as $key => $value) {
            $rand -= $value;
            if ($rand <= 0) {
                return $key;
            }
        }

        return null;
    }
}