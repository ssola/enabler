<?php namespace Enabler;

class Identity
{
    protected $userId = null;
    protected $group = null;

    public function __construct($userId = null, $group = null)
    {
        $this->userId = $userId;
        $this->group = $group;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function setGroup($group)
    {
        $this->group = $group;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getGroup()
    {
        return $this->group;
    }

    public function hasUserId()
    {
        if(!empty($this->userId)) {
            return true;
        }

        return false;
    }

    public function hasGroup()
    {
        if(!empty($this->group)) {
            return true;
        }

        return false;
    }
}