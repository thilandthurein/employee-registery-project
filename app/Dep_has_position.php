<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dep_has_position extends Model
{
	use SoftDeletes;
    public $fillable=['department_id','position_id'];
}
