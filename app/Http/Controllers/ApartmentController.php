<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Apartment;
class ApartmentController extends Controller
{
    //
    public function getAptList(Request $request){
        return Apartment::all();
    }

    public function addApt(Request $request){
        $aptName = $request->aptName;
        return Apartment::create(['aptName'=>$request->aptName]);
    }

    public function updateApt(Request $request){
        return Apartment::where('id',$request->id)->update(['aptName'=>$request->aptName]);
    }

    public function delApt(Request $request){
        $id = $request->id;
        return Apartment::where('id',$request->id)->delete();
    }
}
