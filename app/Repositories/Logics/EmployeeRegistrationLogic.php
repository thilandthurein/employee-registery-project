<?php 

namespace App\Repositories\Logics;

use App\Employee;
use Illuminate\Support\Facades\Config;
use App\Repositories\Interfaces\EmpDepPositionRepositoryInterface;
use Illuminate\Support\Facades\Log;

class EmployeeRegistrationLogic
{
    public function __construct (EmpDepPositionRepositoryInterface $empDepRepo)
    {       
        $this->empDepRepo = $empDepRepo;
    }
    public function savePrepareDate($request)
    {
        $greatest_id=Employee::max('id');
        $position_id=$request['position_id'];
        $department_id=$request['department_id'];
        $pos_id=Config::get('constant.position_id');//position id
        $dep_id=Config::get('constant.department_id');//department id
        if($position_id){ //position_id exit or not exist.
            $position_id=$request['position_id'];
        }else{
            $position_id=$pos_id;
        }
        if($department_id){ //department_id exist or not 
            $department_id=$request['department_id'];
        }else{
            $department_id=$dep_id;
        }
        //dd($department_id);
        // Log::info($department_id);
        $this->empDepRepo->saveEmployeeDep($greatest_id, $position_id, $department_id);
        return true;
    }

    public function updatePrepareDate($request)
    {
        $position_id=$request['position_id'];
        $department_id=$request['department_id'];
        $pos_id=Config::get('constant.position_id');//position id
        $dep_id=Config::get('constant.department_id');//department id
        if($position_id){ //position_id exit or not exist.
            $position_id=$request['position_id'];
        }else{
            $position_id=$pos_id;
        }
        if($department_id){ //department_id exist or not 
            $department_id=$request['department_id'];
        }else{
            $department_id=$dep_id;
        }
        //dd($department_id);
         //Log::info($employee_id);
        $this->empDepRepo->updateEmployeeDep( $request,$position_id, $department_id);
        return true;
    }
}