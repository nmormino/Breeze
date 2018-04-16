<?php namespace Model;

use Illuminate\Database\Eloquent\Model;

class Person extends Model {

    public $timestamps = false;
    protected $primaryKey = 'person_id';
    protected $table = 'people';
    protected $fillable = ['person_id', 'group_id','first_name','last_name', 'email_address', 'state'];

    public function group() {
        return $this->belongsTo('Model\Group', 'group_id', 'group_id');
    }
}
