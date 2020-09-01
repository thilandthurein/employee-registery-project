<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

	/**
     * Get Emp_dep_position attribute .
     * @author Thu Rein Lynn
     * 26.8.2020
     */
class Emp_dep_position extends Model
{
	use SoftDeletes;
    public $fillable=['employee_id','department_id','position_id'];

    
}
