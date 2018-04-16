<?php namespace Model;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {

    public $timestamps = false;
    protected $primaryKey = 'group_id';

    public function people() {
        return $this->hasMany('Model\Person', 'group_id', 'group_id');
    }
}
