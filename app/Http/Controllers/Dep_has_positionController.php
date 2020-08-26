<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dep_has_position;

class Dep_has_positionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dep_positions=Dep_has_position::all();
        return $dep_positions;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dep_position = new Dep_has_position();
        $dep_position->department_id = $request['department_id'];
        $dep_position->position_id = $request['position_id'];
        $dep_position->save();
        return "successful";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dep_positions=find($id);
        return $dep_positions;
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
        $dep_position=Dep_has_position::find($id);
        $dep_position->department_id = $request['department_id'];
        $dep_position->position_id = $request['position_id'];
        $dep_position->save();
        return "successful";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dep_positions=find($id);
        $dep_positions->delete();
    }
}
