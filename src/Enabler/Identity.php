<?php namespace Enabler;

/**
 * Identity object tries to represent your user identity, if you need
 * something personalized you can create a new class from this one.
 * 
 * @package Enabler
 */
class Identity
{
    /**
     * User Id usually an integer that identifies your user
     * 
     * @var mixed
     */
    protected $userId = null;

    /**
     * You can attach to which group belongs this user
     * 
     * @var mixed
     */
    protected $group = null;

    /**
     * Builing the object you can pass the current user id and group
     * 
     * @param mixed $userId
     * @param mixed group
     */
    public function __construct($userId = null, $group = null)
    {
        $this->userId = $userId;
        $this->group = $group;
    }

    /**
     * Set user id on runtime
     * 
     * @param mixed userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Set user group on runtime
     * 
     * @param mixed group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }

    /**
     * Returns user id
     * 
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Returns group
     * 
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Check if we have an user id to compare
     * 
     * @return bool
     */
    public function hasUserId()
    {
        if(!empty($this->userId)) {
            return true;
        }

        return false;
    }

    /**
     * Check if we have a group to compare
     * 
     * @return bool
     */
    public function hasGroup()
    {
        if(!empty($this->group)) {
            return true;
        }

        return false;
    }
}