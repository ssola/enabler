<?php namespace Enabler\Filter\Algorithm;

class RandomWeighted
{
    private $weightedValues = [];

    public function __construct(array $weightedValues)
    {
        if(empty($weightedValues)) {
            throw new \InvalidArgumentException("We need a non empty weighted values array");
        }

        $this->weightedValues = $weightedValues;
    }

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