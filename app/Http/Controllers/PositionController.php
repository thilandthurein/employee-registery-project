<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Position;
use App\Http\Requests\PositionRequest;
use Illuminate\Support\Facades\config;

    /**
     * CRUD for Position table .
     * @author Thu Rein Lynn
     * 26.8.2020
     */
class PositionController extends Controller
{ 
    /**
     * Display a listing of the position table.
     * @author Thu Rein Lynn
     * 26.8.2020
     *
     * @return array[id,position_name,position_rank,deleted_at,created_at,updated_at] 
     */
     public function index()
    {
        $per_page=Config::get('constant.per_page');
        $positions=Position::paginate($per_page);
        return response()->json(['status'=>'OK','message'=>$positions],200);
    }

    /**
     * Storing data to position table.
     * @author Thu Rein Lynn
     * 26.8.2020
     * @param PositionRequest
     * @return 
     */
     public function store(PositionRequest $request)
    {
        $position = new Position();
        $position->position_name = $request['position_name'];
        $position->position_rank = $request['position_rank'];
        $position->save();
        return response()->json(['status'=>'OK','message'=>"Save Successful"],200);
    }

    /**
     * Display the specified position as id.
     * @author Thu Rein Lynn
     * 28.8.2020
     * @param $id
     * @return array[id,position_name,position_rank,deleted_at,created_at,updated_at] 
     */
     public function detail($id)
    {
        $positions=Position::withTrashed()->whereId($id)->first();
        if(is_null($positions)){ //search position data by id exist or not exist.
            return response()->json(['status'=>'NG','message'=>"Id not found!"],200);
        }
         return response()->json(['status'=>'OK','message'=>$positions],200);
    }

    /**
     * Update the position resource in storage as position_id.
     * @author Thu Rein Lynn
     * 26.8.2020
     * @param PositionRequest,$id
     * @return 
     */
     public function update(PositionRequest $request, $id)
    {
    	$position=Position::find($id);
        if(is_null($position)){ //search position data by id exist or not exist.
           return response()->json(['status'=>'NG','message'=>"Id not found!"],200);
        }
    	$position->position_name = $request['position_name'];
    	$position->position_rank = $request['position_rank'];
    	$position->save();
        return response()->json(['status'=>'OK','message'=>"Upadate Successful."],200);
    }

    /**
     * Update current_time into deleted_at column as id.
     * @author Thu Rein Lynn
     * 27.8.2020
     * @param $id
     * @return 
     */
    public function delete($id)
    {
        $position=Position::withTrashed()->whereId($id)->first();
        if(is_null($position)){ //search position data by id exist or not exist.
            return response()->json(['status'=>'NG','message'=>"Id not found!"],200);
        }
        $position->delete(); 
        return response()->json(['status'=>'OK','message'=>"Update current time."],200);
    }

    /**
     * Remove the position table row from storage as position_id.
     * @author Thu Rein Lynn
     * 27.8.2020
     * @param $id
     * @return 
     */
    public function forcedelete($id)
    {
        $position=Position::withTrashed()->whereId($id)->first();
        if(is_null($position)){ //search position data by id exist or not exist.
            return response()->json(['status'=>'NG','message'=>"Id not found!"],200);
        }
        $position->forcedelete(); 
        return response()->json(['status'=>'OK','message'=>"Delete Successful."],200);
    }
}
