<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

	/**
     * Get department attribute .
     * @author Thu Rein Lynn
     * 26.8.2020
     */
class Department extends Model
{
	use SoftDeletes;
    public $fillable=['department_name'];
}
