<?php namespace Model;

use Illuminate\Database\Eloquent\Model;

class Person extends Model {

    public $timestamps = false;
    protected $primaryKey = 'person_id';
    protected $table = 'people';

    public function group() {
        return $this->belongsTo('Model\Group', 'group_id', 'group_id');
    }
}
