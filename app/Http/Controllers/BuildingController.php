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
    
    public function delBuilding(Request $request)
    {
        $buildingId = $request->id;
        return Building::where('id', $buildingId)->delete();
    }

    public function updateBuilding(Request $request){
        $this->validate($request,[
            'id'=>'required',
            'number'=>'required',
        ]);
        return Building::where('id',$request->id)->update([
            'number'=>$request->number
        ]);
    }
}
