<?php
include_once("vendor/autoload.php");

$enabler = new Enabler\Enabler(new Enabler\Storage\Redis([]));
$feature = new Enabler\Feature("Music", true, ["Enabler\Filter\Percentage" => 9]);
$enabler->storage()->create($feature); 

var_dump($enabler->enabled("Music"));