<?php namespace Enabler\Filter;

use Enabler\Feature;
use Enabler\Identity;

class Identifier implements Filterable
{
    public function filter ($data, Feature $feature, Identity $identity)
    {
        if(!is_array($data)) {
            throw new \InvalidArgumentException("Input data is wrong");
        }

        if(!isset($data['userIds']) && !isset($data['groups'])) {
            throw new \InvalidArgumentException("Missing user ids or groups");
        }

        if($identity->hasUserId() && isset($data['userIds'])) {
            foreach($data['userIds'] as $userId) {
                if ($userId == $identity->getUserId()) {
                    return true;
                }
            }
        }

        if($identity->hasGroup() && isset($data['groups'])) {
            foreach($data['groups'] as $group) {
                if ($group == $identity->getGroup()) {
                    return true;
                }
            }
        }

        return false;
    }
}