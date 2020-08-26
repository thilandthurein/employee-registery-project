<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Emp_dep_position;
use Illuminate\Support\Facades\Hash;
use Carbon\carbon; 

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees=Employee::all();
        return $employees;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
        $employee= new Employee();
        $employee->employee_name= $request['employee_name'];
        $employee->email= $request['email'];
        $employee->dob= $request['dob'];
        $employee->password= Hash::make($request['password']);
        $employee->gender= $request['gender'];
        $employee->save();

        $greatest_id=Employee::max('id');
        $position_id=$request['position_id'];
        $department_id=$request['department_id'];
        if($position_id){
            $position_id=$request['position_id'];
        }else{
            $position_id=1;
        }
        if($department_id){
            $department_id=$request['department_id'];
        }else{
            $department_id=1;
        }
        $employee_dep_pos=new Emp_dep_position();
        $employee_dep_pos->employee_id=$greatest_id;
        $employee_dep_pos->department_id=$department_id;
        $employee_dep_pos->position_id=$position_id;
        $employee_dep_pos->save();
      // return "successful";
        return response()->json([
            'message'=>'Success Employee Registration'
        ],200);
        }catch(QueryException $e){
            return response()->json([
                'message'=>$e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employees=Employee::find($id);
        return $employees;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $employee=Employee::find($id);
        $employee->employee_name = $request['employee_name'];
        $employee->email = $request['email'];
        $employee->dob = $request['dob'];
        $employee->password =Hash::make( $request['password']);
        $employee->gender = $request['gender'];
        $employee->save();
        //return "successful";

        /* $position_id=$request['position_id'];
        $department_id=$request['department_id'];
        if($position_id){
            $position_id=$request['position_id'];
        }else{
            $position_id=1;
        }
        if($department_id){
            $department_id=$request['department_id'];
        }else{
            $department_id=1;
        }
        $employee_dep_pos=Emp_dep_position::where('employee_id',$id)->first();
        $employee_dep_pos->department_id=$department_id;
        $employee_dep_pos->position_id=$position_id;
        $employee_dep_pos->save();*/

        if($request->position_id){
            $pos_id=$request->position_id;
        }else{
            $pos_id=1;
        }
         $employee_dep_pos=Emp_dep_position::where('employee_id',$id)->first();
         if($employee_dep_pos){
            if($request->department_id){
                $employee_dep_pos->department_id=$request->department_id;
            }
            if($request->position_id){
                $employee_dep_pos->position_id=$pos_id;
            }
            $employee_dep_pos->save();
         }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       /* $employee=Employee::find($id);
        $employee->delete();*/
        $employee=Employee::whereId($id)->firstOrFail();
        $employee->softdeletes();
    }

    public function delete($id)
    {   

        $employee = Employee::find($id);
        $employee->deleted_at=Carbon::now();
        $employee->save();
    }
}
