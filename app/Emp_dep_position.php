<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emp_dep_position extends Model
{
    public $fillable=['employee_id','department_id','position_id'];
}
