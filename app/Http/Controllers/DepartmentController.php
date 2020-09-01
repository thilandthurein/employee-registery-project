<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use App\Http\Requests\DepartmentRequest;
use Illuminate\Support\Facades\config;


    /**
     * CRUD for Department table .
     * @author Thu Rein Lynn
     * 26.8.2020
     */
class DepartmentController extends Controller
{
    /**
     * Display a listing of the employee table.
     * @author Thu Rein Lynn
     * 26.8.2020
     *
     * @return array[id,department_name,deleted_at,created_at,updated_at]
     */
	 public function index()
    {
       $per_page=Config::get('constant.per_page');
       $departments=Department::withTrashed()->paginate($per_page);
        return response()->json(['status'=>'OK','message'=>$departments],200);
    }

    /**
     * Storing data to Database employee table.
     * @author Thu Rein Lynn
     * 26.8.2020
     * @param DepartmentRequest
     * @return 
     */
     public function store(DepartmentRequest $request)
    {
        $department = new Department();
        $department->department_name = $request['department_name'];
        $department->save();
        return response()->json(['status'=>'OK','message'=>"Save Successful"],200);
    }

    /**
     * Display the specified employee table row as id .
     * @author Thu Rein Lynn
     * 28.8.2020
     * @param $id
     * @return array[id,department_name,deleted_at,created_at,updated_at]
     */
     public function detail($id)
    {
        $departments=Department::withTrashed()->whereId($id)->first();
        if(is_null($departments)){ //
            return response()->json(['status'=>'NG','message'=>"Id not found!"],200);
        }
        return response()->json(['status'=>'OK','message'=>$departments],200);
    }

    /**
     * Update the department resource in storage as id.
     * @author Thu Rein Lynn
     * 26.8.2020
     * @param $request,$id
     * @return 
     */
     public function update(Request $request, $id)
    {
    	$department=Department::withTrashed()->find($id);
        if(is_null($department)){ //search department data by id exist or not exist.
           return response()->json(['status'=>'NG','message'=>"Id not found!"],200);
        }
    	$department->department_name = $request['department_name'];
    	$department->update();
        return response()->json(['status'=>'OK','message'=>'Update Successful.'],200);
    }

    /**
     * Update current_time into deleted_at column.
     * @author Thu Rein Lynn
     * 27.8.2020
     * @param $id
     * @return 
     */
    public function delete($id)
    {
        $department=Department::withTrashed()->whereId($id)->first();
        if(is_null($department)){ //search department data by id exist or not exist.
            return response()->json(['status'=>'NG','message'=>"Id not found!"],200);
        }
        $department->delete();
       return response()->json(['status'=>'OK','message'=>"Update current time into deleted_at"],200);
    }

    /**
     * Remove the specified resource from storage.
     * @author Thu Rein Lynn
     * 27.8.2020
     * @param $id
     * @return 
     */
    public function forcedelete($id)
    {
        $department=Department::withTrashed()->whereId($id)->first();
        if(is_null($department)){ //search department data by id exist or not exist.
             return response()->json(['status'=>'NG','message'=>"Id not found!"],200);
        }
        $department->forcedelete();
        return response()->json(['status'=>'OK','message'=>"Delete Successful."],200);
    }
}
