<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $fillable=['employee_name','email','password','gender','department_id','position_id'];
}
