<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dep_has_position extends Model
{
    public $fillable=['department_id','position_id'];
}
