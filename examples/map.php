<?php

require_once __DIR__.'/../vendor/autoload.php';
$r = new Shela\DisplayPurposes\Client();
$request = new Shela\DisplayPurposes\Api\Request();
$tags = $r->query($request)->map(36.107768481029, -115.17178021162, 200);
var_dump($tags);
