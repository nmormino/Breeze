<?php namespace Library;

class Import {

    public $errors = [];
    public $records = [];
    public $type = false;

    public function __construct(Array $records) {

        $this->errors = [];
        $this->records = $records;
        $this->type = $this->detectType();
    }

    public function detectType() {
        if(empty($this->records)) {
            return false;
        } else {
            if(isset($records[0]['person_id'])){
                return 'Person';
            } elseif($records[0]['group_name']) {
                return 'Group';
            } else {
                return false; // invalid CSV
            }
        }
    }

    public function process() {

        if($this->type == 'Person') {
            $this->processPeople();
        } elseif ($this->type == 'Group') {
            $this->processGroups();
        } else {
            throw new Exception('Unable to process invalid CSV.');
        }
    }

    private function processPeople() {
        foreach($this->records as $person) {

        }
    }

    private function processGroups() {
        foreach($this->records as $group) {

        }
    }

}
