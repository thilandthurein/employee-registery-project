<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Position;

class PositionController extends Controller
{
     public function index()
    {
       $positions=Position::all();
        return $positions;
    }

     public function store(Request $request)
    {
        $position = new Position();
        $position->position_name = $request['position_name'];
        $position->position_rank = $request['position_rank'];
        $position->save();
        return "successful";
    }

     public function detail($id)
    {
        $positions=Position::find($id);
        return $positions;
    }

     public function update(Request $request, $id)
    {
    	$position=Position::find($id);
    	$position->position_name = $request['position_name'];
    	$position->position_rank = $request['position_rank'];
    	$position->save();
        return "successful";
    }

    public function delete($id)
    {
        
    }
}
