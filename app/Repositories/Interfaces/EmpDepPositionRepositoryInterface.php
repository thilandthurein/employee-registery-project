<?php

namespace App\Repositories\Interfaces;

interface EmpDepPositionRepositoryInterface 
{
    public function saveEmployeeDep($greatest_id, $position_id, $department_id);
    public function updateEmployeeDep($request,$position_id, $department_id);
}