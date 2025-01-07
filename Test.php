<?php
require 'vendor/autoload.php';

use AmsApp\Utils\PhpMap\PhpMap;

$list = new \AmsApp\Utils\PhpMap\MapWrapper();
$list->put("Item 1","A");

$list->entrySet()->echoList();
