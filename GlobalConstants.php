<?php

namespace AmsApp;

$serveName = $_SERVER['SERVER_NAME'];
class GlobalConstants
{
    const SITE_TITLE = 'AmsPortal';
    const BASE_DIR = __DIR__;
    const HOST_NAME = "hostname";
    const SITE_CONTEXT = "/ams-portal";

    const CONTENT_TYPE_APPLICATION_JSON = 'Content-Type: application/json';
}

if (!defined('SITE_PATH'))
{
    define("SITE_PATH", dirname(realpath(__FILE__)));
    set_include_path(get_include_path() . PATH_SEPARATOR . SITE_PATH);
}



