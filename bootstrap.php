<?php
include('vendor/autoload.php');

use Illuminate\Database\Capsule\Manager as DB;
use Library\Import;
use Model\Group;

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
                echo json_encode(['messages'=>['error'=>true, 'message'=>'Import Failed, invalid CSV.']]);
                break;
            } else {
                $results = $import->process();
                echo json_encode($results);
                break;
            }

        } else {
            echo json_encode([['error'=>true, 'message'=>'Import Failed, invalid post data.']]);
            break;
        }
        break;
    case 'get-records':
        echo json_encode(['groups'=>Group::with('people')->get()->toArray()]);
        break;
    default:
        throw new Exception('Invalid action.');
}
