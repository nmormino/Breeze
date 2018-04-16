<?php namespace Controller;

use Library\Import;
use Model\Group;

class Router {

    private $action = null;
    
    public function __construct(string $action) {
        $this->action = $action;
    }

    public function index() {

        switch ($this->action) {
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
                throw new \Exception('Invalid action.');
        }

    }
}
