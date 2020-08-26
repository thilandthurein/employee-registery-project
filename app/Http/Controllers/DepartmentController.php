<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;

class DepartmentController extends Controller
{
	 public function index()
    {
       $departments=Department::all();
        return $departments;
    }

     public function store(Request $request)
    {
        $department = new Department();
        $department->department_name = $request['department_name'];
        $department->save();
        return "successful";
    }

     public function detail($id)
    {
        $departments=Department::find($id);
        return $departments;
    }

     public function update(Request $request, $id)
    {
    	$department=Department::find($id);
    	$department->department_name = $request['department_name'];
    	$department->save();
        return "successful";
    }

    public function delete($id)
    {
        $department=Department::find($id)->firstOrFail();
        $department->delete();
    }
}
