<?php namespace Model;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {

    public $timestamps = false;
    protected $primaryKey = 'group_id';
    protected $fillable = ['group_id','group_name'];

    public function people() {
        return $this->hasMany('Model\Person', 'group_id', 'group_id');
    }
}
