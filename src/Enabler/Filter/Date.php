<?php namespace Enabler\Filter;

use Enabler\Feature;
use Enabler\Identity;
use DateTime;

/**
 * Check if we can display the Feature depending on given date
 * 
 * @package Enabler\Filter
 */
class Date implements Filterable
{
    /**
     * Filter by date or date range
     * 
     * @param array $data
     * @param Feature $feature
     * @param Identity $identity
     * @return bool
     */
    public function filter (array $data, Feature $feature, Identity $identity)
    {
        if (count($data) == 2) {
            return $this->checkByRange($data);
        }

        if(!isset($data[0])) {
            throw new \InvalidArgumentException("Missing start date");
        }

        $this->validateDate($data[0]);
        $startDate = $data[0];

        $currentDate = $this->getCurrentDate();

        if($currentDate >= $startDate) {
            return true;
        }

        return false;
    }

    /**
     * Check if given range is valid for current date
     * 
     * @param array $range
     * @return bool
     */
    protected function checkByRange(array $range)
    {
        if (!isset($range['from']) || !isset($range['to'])) {
            throw new \InvalidArgumentException("Range missing parameter from or to!");
        }

        $this->validateDate($range['from']);
        $this->validateDate($range['to']);

        $currentDate = $this->getCurrentDate();

        if($currentDate >= $range['from'] && $currentDate <= $range['to']) {
            return true;
        }

        return false;
    }

    /**
     * Check if given variable is an instance of DateTime
     * 
     * @param $date DateTime
     * @return bool
     */
    protected function validateDate(DateTime $date) {
         return true;
    }

    /**
     * Returns current date with DateTime object
     * 
     * @return DateTime
     */
    protected function getCurrentDate()
    {
        return new DateTime();
    }
}