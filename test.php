<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

include_once("./vendor/autoload.php");

$configuration = [];

$enabler = new Enabler\Enabler(new Enabler\Storage\Redis($configuration));

// create new feature
//$feature = new Enabler\Feature("Music", true, ["Enabler\Validator\Ip" => array("127.0.2.1")]);
$feature = new Enabler\Feature("Music", true, ["Enabler\Validator\Percentage" => 10]);
$enabler->storage()->create($feature);
var_dump($enabler->enabled("Music"));die;
