<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//For Request Controller
use App\Http\Requests\EmployeeUpdateValidationRequest;

//For Employee EmployeeRepositoryInterface and EmployeeRegistrationLogic
use App\Repositories\Logics\EmployeeRegistrationLogic;
use App\Http\Requests\EmployeeRegistrationValidationRequest;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;

class EmployeeRegistrationController extends Controller
{
    public function __construct(EmployeeRepositoryInterface $employeeRepo,
                                EmployeeRegistrationLogic $employeeLogic)
    {       
        $this->employeeRepo = $employeeRepo;
        $this->employeeLogic = $employeeLogic;
    }
    public function save(EmployeeRegistrationValidationRequest $request)
    {
        $this->employeeRepo->saveEmployee($request); 
        $this->employeeLogic->savePrepareDate($request);  
        return response()->json(['status'=>'OK',
            'message'=>'Success Employee Registration'
        ],200); 
    }
    public function update(EmployeeUpdateValidationRequest $request){
        $employee = $this->employeeRepo->checkEmployee($request);
        
        if($employee->isEmpty()) {
            return response()->json(['status'=>'NG','message'=>'Id not found!'],200);
        } else {
            $this->employeeRepo->updateEmployee($request);
            $this->employeeLogic->updatePrepareDate($request);            
        }

    }
}
