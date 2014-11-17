<?php
include_once("vendor/autoload.php");

class MyIdentity extends Enabler\Identity {
    public function __construct()
    {
        parent::__construct(12, "God");
    }
}

$MyIdentity = new \MyIdentity();

$enabler = new Enabler\Enabler(new Enabler\Storage\Redis([]), $MyIdentity);
        $feature = new Enabler\Feature(
            "secret-project", true, [
                "Enabler\Filter\Identifier" => [
                    "groups" => [
                        "test", "early-adopters", "God"
                    ]
                ],
                "Enabler\Filter\Identifier" => [
                    "userIds" => [
                        1, 2, 3, 10, 34, 54, 65, 24, 543, 564645, 23, 432, 54, 656
                    ]
                ]
            ]
        );
$enabler->storage()->create($feature); 

var_dump($enabler->enabled("Music"));