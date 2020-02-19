<?php
/**
 * Created by PhpStorm.
 * User: Rafael Freitas
 * Date: 18/02/2019
 * Time: 12:00
 */

ini_set('display_errors',0);
ini_set('display_startup_erros',0);
//error_reporting(0);
error_reporting(E_ALL);
//error_reporting(E_ALL & ~E_NOTICE);

//Groups
// 1 -> Admin
// 2 -> Cliente

require_once 'vendor/autoload.php';
require 'src/Config/Slim.php';

require 'src/Groups/AddressGroup.php';
require 'src/Groups/AuthGroup.php';
require 'src/Groups/ClientGroup.php';

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
    $handler = $this->notFoundHandler;
    return $handler($req, $res);
});

$app->run();