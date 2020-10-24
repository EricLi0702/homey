<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Building;
class BuildingController extends Controller
{
    //
    public function getBuildingList(Request $request){
        $aptId = $request->id;
        return Building::where('aptid',$aptId)->get();
    }

    public function addBuilding(Request $request){
        $this->validate($request,[
            'aptId'=>'required',
            'number'=>'required'
        ]);

        return Building::create(['aptId'=>$request->aptId,'number'=>$request->number]);
    }
}
