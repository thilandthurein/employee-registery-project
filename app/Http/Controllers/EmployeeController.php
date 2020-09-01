<?php

namespace App\Http\Controllers;

use PDF;
use App\Employee;
use App\Emp_dep_position;
use Illuminate\Http\Request;
use App\Exports\EmployeesExport;
use App\Imports\EmployeesImport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Support\Facades\config;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder; 

    /**
     * CRUD and excel-export for Employee table .
     * @author Thu Rein Lynn
     * 26.8.2020
     */
class EmployeeController extends Controller
{
    /**
     * Display a listing of the employee table.
     * @author Thu Rein Lynn
     * 26.8.2020
     *
     * @return array[id,employee_name,emil,dob,password,gender,deleted_at,created_at,updated_at,department,position]
     */
    public function index()
    {  
        $per_page=Config::get('constant.per_page');
        $employees = Employee::with('department','position')->withTrashed()->paginate($per_page);
        return response()->json(['status'=>'OK','message'=>$employees],200);
    }

    /**
     * Storing data to employee table.
     * @author Thu Rein Lynn
     * 26.8.2020
     * @param EmployeeRequest
     * @return 
     */
    public function store(EmployeeRequest $request)
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
        $employee_dep_pos=new Emp_dep_position();
        $employee_dep_pos->employee_id=$greatest_id;
        $employee_dep_pos->department_id=$department_id;
        $employee_dep_pos->position_id=$position_id;
        $employee_dep_pos->save();


        Mail::raw('Your registration process is finish.',function($message){
                $message->subject('Thu Rein Lynn')->from('lonlon.blah@gmail.com')->to('thureinlynn.acc4889@gmail.com');
            });
        return response()->json(['status'=>'OK',
            'message'=>'Success Employee Registration'
        ],200);
        }catch(QueryException $e){
            return response()->json([
                'message'=>$e->getMessage()
            ]);
        }
    }

   /**
     * Display the employee row as id .
     * @author Thu Rein Lynn
     * 27.8.2020
     * @param $id
     * @return array[id,employee_name,emil,dob,password,gender,deleted_at,created_at,updated_at,department,position]
     */
    public function show($id)
    {
        $employees=Employee::withTrashed()->whereId($id)->with('department','position')->first();
        if(is_null($employees)){ //search employee data by id exist or not exist.
            return response()->json(['status'=>'NG','message'=>'Id not found.'],200);
        }
        return response()->json(['status'=>'OK','message'=>$employees],200);;

    }

   /**
     * Update time into deleted_at column.
     * @author Thu Rein Lynn
     * 26.8.2020
     * @param EmployeeRequest,$id
     * @return 
     */
    public function update(Request $request, $id)
    {
        $employee=Employee::find($id);
        if(is_null($employee)){ //search employee data by id exist or not exist.
            return response()->json(['status'=>'NG','message'=>'Id not found!'],200);
        }else{
        $employee->employee_name = $request['employee_name'];
        $employee->email = $request['email'];
        $employee->dob = $request['dob'];
        $employee->password =Hash::make( $request['password']);
        $employee->gender = $request['gender'];
        $employee->update();
        }
        $pos_id=Config::get('constant.position_id');//position id
        $dep_id=Config::get('constant.department_id');//department id
        if($request->position_id){ //position id exist or not exist
            $position_id=$request->position_id;
        }else{
            $position_id=$pos_id;
        }
         $employee_dep_pos=Emp_dep_position::where('employee_id',$id)->first();
         if($employee_dep_pos){ //department id exist or not exist
            if($request->department_id){
                $employee_dep_pos->department_id=$request->department_id;
            }
            if($request->position_id){ //position id exist or not exist
                $employee_dep_pos->position_id=$position_id;
            }
            $employee_dep_pos->update();
            return response()->json(['status'=>'OK','message'=>'Update Successful.'],200);
         }

    }

     /**
     * Update current_time into deleted_at column.
     * @author Thu Rein Lynn
     * 28.8.2020
     * @param $id
     * @return array[id,employee_name,emil,dob,password,gender,deleted_at,created_at,updated_at]
     */
    public function destroy($id)
    {
        $employee=Employee::withTrashed()->whereId($id)->first();
         if(is_null($employee)){ //search employee data by id exist or not exist.
            return response()->json(['status'=>'NG','message'=>'Id not found!'],200);
        }
        $employee->delete(); 
       
        $employee_dep_pos=Emp_dep_position::withTrashed()->where('employee_id',$id)->first();
        $employee_dep_pos->delete();
        return response()->json(['status'=>'OK','message'=>'Update current_time into deleted_at.'],200);
    }
    
    /**
     * Remove the specified resource from storage.
     * @author Thu Rein Lynn
     * 28.8.2020
     * @param $id
     * @return 
     */
    public function delete($id)
    {   
        $employee = Employee::withTrashed()->where('id',$id)->first();
         if(is_null($employee)){ //search employee data by id exist or not exist.
            return response()->json(['status'=>'NG','message'=>'Id not found!'],200);
        }
        $employee->forcedelete();

        $employee_dep_pos=Emp_dep_position::withTrashed()->where('employee_id',$id)->first();
        $employee_dep_pos->forcedelete();
        return response()->json(['status'=>'OK','message'=>'Delete Successful.'],200);
    }

    /**
     * Search the employee data with id or name.
     * @author Thu Rein Lynn
     * 28.8.2020
     * @param $request
     * @return 
     */
    public function search(Request $request){
        $employee_name = $request['employee_name'];
        $id = $request['employee_id'];
        $search_data=[];
        if($id){ //employee_id exist or not exist
            $search_id=['id',$id];
            array_push($search_data,$search_id);
        }
        if($employee_name){ //employee_name exist or not exist
            $search_name=['employee_name','like',$employee_name.'%'];
            array_push($search_data,$search_name);
        }
        $per_page=Config::get('constant.per_page');
        $employees = Employee::with('department','position')
                        ->withTrashed()
                        ->where($search_data)
                        ->paginate($per_page);
        return response()->json(['status'=>'OK','message'=>$employees],200);
    }   

        /**
     * Excel export employee list with three column.
     * @author Thu Rein Lynn
     * 29.8.2020
     * @param $request
     * @return array[employee_name,email,dob,gender,position_id,department_id]
     */
    public function fileExport(Request $request)
    {
        $data=[];
        $id=$request->id;
        $employee_name=$request->employee_name;
        if($id){ //employee_id exist or not exist
            $search_id=['employees.id',$id];
            array_push($data,$search_id);
        }
        if($employee_name){ //employee_name exist or not exist
            $search_name=['employees.employee_name',$employee_name];
            array_push($data,$search_name);
        }

         return Excel::download(new EmployeesExport($data),'EmployeeList.xlsx');
    } 


    public function exportPdf() {
        // retreive all records from db
        $data = Employee::all();
        // share data to view
        view()->share('employee',$data);
        $pdf = PDF::loadView('pdf_view', $data);
        // download PDF file with download method
        return $pdf->download('pdf_file.pdf');
            }
    }