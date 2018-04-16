<?php
include('vendor/autoload.php');

use Illuminate\Database\Capsule\Manager as DB;
use Library\Import;

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

switch ($action) {
    case 'import':
        if(isset($_POST['csv'])) {

            $import = new Import($_POST['csv']);
            if(!$import->type) {
                echo json_encode(['message'=>'Import Failed, invalid CSV.']);
                return;
            } else {
                $import->process();
            }

        } else {
            echo json_encode(['message'=>'Import Failed, invalid post data.']);
            return;
        }

        //do import person
        $controller = new Person;
        $controller->index();
        break;
    default:
        throw new Exception('Invalid action.');
}
