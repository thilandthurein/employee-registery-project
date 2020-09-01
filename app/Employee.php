<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

    /**
     * Join table and get employee_attribute .
     * @author Thu Rein Lynn
     * 26.8.2020
     */
class Employee extends Model
{
	use SoftDeletes;
    public $fillable=['employee_name','email','password','gender','department_id','position_id'];

    /**
     * Join departments and employees table.
     * Thu Rein Lynn
     * 27.8.2020
     *
     * @return 
     */
    public function department(){
    	return $this->belongsToMany('App\Department','emp_dep_positions','employee_id','department_id');
    }

    /**
     * Join positions and employees table.
     * Thu Rein Lynn
     * 27.8.2020
     *
     * @return 
     */
    public function position(){
    	return $this->belongsToMany('App\Position','emp_dep_positions','employee_id','position_id');
    }   
}
