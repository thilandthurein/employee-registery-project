<?php

namespace App\Repositories;


use App\Emp_dep_position;
use App\Repositories\Interfaces\EmpDepPositionRepositoryInterface;
use Exception;

//use Your Model

/**
 * Class EmployeeRepository.
 */
class EmpDepPositionRepository implements EmpDepPositionRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function saveEmployeeDep($greatest_id, $position_id, $department_id)
    {
     $emp_dep_position=new Emp_dep_position();
     $emp_dep_position->employee_id=$greatest_id;
     $emp_dep_position->department_id=$department_id;
     $emp_dep_position->position_id=$position_id;
     $emp_dep_position->save();

     try{
     $emp_dep_position->save();
        return true;
    }catch(Exception $e){
        return false;
    }
    }

    public function updateEmployeeDep($request,$position_id, $department_id)
    {
    $employee_dep_pos=Emp_dep_position::where('employee_id',$request->id)->first();
    $employee_dep_pos->department_id=$department_id;
    $employee_dep_pos->position_id=$position_id;
    $employee_dep_pos->update();

    }
}
