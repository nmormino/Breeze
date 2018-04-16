<?php namespace Library;

use Model\Person;
use Model\Group;

class Import {

    public $messages = [];
    public $records = [];
    public $type = false;

    //groups are not needed for group imports
    public $groups = null;

    public function __construct(Array $records) {

        $this->messages = [];
        $this->records = $records;
        $this->groups = null;
        $this->type = $this->detectType();
    }

    public function detectType() {
        if(empty($this->records)) {
            return false;
        } else {
            if(isset($this->records[0]['person_id'])){
                return 'Person';
            } elseif(isset($this->records[0]['group_name'])) {
                return 'Group';
            } else {
                return false; // invalid CSV
            }
        }
    }

    public function process() {
        if($this->type == 'Person') {
            return $this->processPeople();
        } elseif ($this->type == 'Group') {
            return $this->processGroups();
        } else {
            throw new \Exception('Unable to process invalid CSV.');
        }
    }

    private function getGroups(){
        $this->groups = Group::all();
    }

    private function processPeople() {

        //load in the groups
        $this->getGroups();
        $groupIds = $this->groups->pluck('group_id')->toArray();

        $count = 1;
        foreach($this->records as $record) {
            if(!in_array($record['group_id'], $groupIds)) {
                $this->messages[] = [
                    'error'=>true,
                    'message'=>'ROW '.$count.': Invalid Group ID.'
                ];
            } else {
                //either return the existing user to update or create a new one
                $person = Person::firstOrNew(['person_id'=>$record['person_id']]);
                $person->first_name = $record['first_name'];
                $person->last_name = $record['last_name'];
                $person->email_address = $record['email_address'];
                $person->group_id = $record['group_id'];
                $person->state = $record['state'];

                //save the person
                $person->save();

                $this->messages[] = [
                    'error'=>false,
                    'message'=>'ROW '.$count.': Person successfully imported.'
                ];
            }
            $count++; //we can tell them which row has an invalid group id
        }
        //lets hope our return is empty :) that would mean no errors!
        return $this->messages;
    }

    private function processGroups() {
        $count = 1;
        foreach($this->records as $record) {
            $group = Group::firstOrNew(['group_id'=>$record['group_id']]);
            $group->group_name = $record['group_name'];
            $group->save();

            $this->messages[] = [
                'error'=>false,
                'message'=>'ROW '.$count.': Group successfully imported.'
            ];

            $count++;
        }
        //since we're not validating anything such as non-existent group_id return empty
        return $this->messages;
    }

}
