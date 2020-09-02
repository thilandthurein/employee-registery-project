<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//For Request Controller
use App\Http\Requests\PositionRequest;

//For Employee EmployeeRepositoryInterface and EmployeeRegistrationLogic
use App\Repositories\Interfaces\PositionRepositoryInterface;

class PositionRegistrationController extends Controller
{
    public function __construct(PositionRepositoryInterface $positionRepo)
    {       
        $this->positionRepo = $positionRepo;
    }
    public function save(PositionRequest $request)
    {
        $this->positionRepo->savePosition($request); 
        return response()->json(['status'=>'OK',
            'message'=>'Success Position Registration'
        ],200); 
    }
}
