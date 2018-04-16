<?php
include('vendor/autoload.php');

use Illuminate\Database\Capsule\Manager as DB;
use Controller\Router;

//fire up the database layer
$db = new DB;
$db->addConnection([
    'driver'    => 'mysql',
    'host'      => '127.0.0.1',
    'database'  => 'breeze',
    'username'  => 'homestead',
    'password'  => 'secret'
]);
$db->setAsGlobal();
$db->bootEloquent();

//get the action from our URL parameters
$action = ($_GET['action'])?$_GET['action']:false;
$router = new Router($action);
$router->index();
