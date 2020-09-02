<?php

namespace App\Repositories;

use App\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
//use Your Model

/**
 * Class EmployeeRepository.
 */
class EmployeeRepository implements EmployeeRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function saveEmployee($request)
    {
        try{
            $employee= new Employee();
            $employee->employee_name= $request['employee_name'];
            $employee->email= $request['email'];
            $employee->dob= $request['dob'];
            $employee->password= Hash::make($request['password']);
            $employee->gender= $request['gender'];
            $employee->save();
            return response()->json(['status'=>'OK',
                'message'=>'Success Employee Registration'
            ],200);
            }catch(QueryException $e){
                return response()->json([
                    'message'=>$e->getMessage()
                ]);
            }
    }

    public function checkEmployee($request)
    {
        $employeeId=$request['id'];
        $employee=DB::table('employees')
                            ->leftJoin('emp_dep_positions','employees.id','=','emp_dep_positions.employee_id')
                            ->where('employees.id',$employeeId)
                            ->get();
        return $employee;      
    }

    public function updateEmployee($request)
    {
        $employeeId=$request['id'];
        $employeeName=$request['employee_name'];
        $email=$request['email'];
        $password=Hash::make($request['password']);
        $dob=$request['dob'];
        $gender=$request['gender'];
                    DB::table('employees')
                    ->where('id', $employeeId)
                    ->update(['employee_name' =>$employeeName,
                    'email' =>$email,
                    'password' =>$password,
                    'dob' =>$dob,
                    'gender'=>$gender]);
    }
}