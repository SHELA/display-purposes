<?php

require_once __DIR__.'/../vendor/autoload.php';
$r = new Shela\DisplayPurposes\Client();
$request = new Shela\DisplayPurposes\Api\Request();
$tags = $r->query($request)->tags('lasvegas');
var_dump($tags);
