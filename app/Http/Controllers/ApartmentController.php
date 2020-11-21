<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Apartment;
use App\User;

class ApartmentController extends Controller
{
    //
    public function getAptList(Request $request){
        return Apartment::all();
    }

    public function addApt(Request $request){
        $this->validate($request,[
            'aptName'=>'required',
            'address'=>'required',
            'repreName'=>'required',
            'phoneNumber'=>'required',
            'email'=>'required'
        ]);
        $aptName = $request->aptName;
        $address = $request->address;
        $repreName = $request->repreName;
        $phoneNumber = $request->phoneNumber;
        $email = $request->email;
        $rand = mt_rand(100000, 999999);
        $code = $rand.time();
        return Apartment::create([
            'aptName'=>$aptName,
            'address'=>$address,
            'repreName'=>$repreName,
            'phoneNumber'=>$phoneNumber,
            'email'=>$email,
            'code'=>$code
        ]);
    }

    public function updateApt(Request $request){
        $this->validate($request,[
            'aptName'=>'required',
            'address'=>'required',
            'repreName'=>'required',
            'phoneNumber'=>'required',
            'email'=>'required'
        ]);
        $aptName = $request->aptName;
        $address = $request->address;
        $repreName = $request->repreName;
        $phoneNumber = $request->phoneNumber;
        $email = $request->email;
        $id = $request->id;
        return Apartment::where('id',$request->id)->update([
            'aptName'=>$aptName,
            'address'=>$address,
            'repreName'=>$repreName,
            'phoneNumber'=>$phoneNumber,
            'email'=>$email
        ]);
    }

    public function updateAutoMode(Request $request){
        if ($request->autoMode == true){
            $apartmentData =  Apartment::where('id', Auth::user()->aptId)->first();
            $apartmentData['isAutoReserve'] = 1;
            $apartmentData->save();
            return response()->json([
                'msg'=> 1,
            ]);
        }
        if ($request->autoMode == false){
            $apartmentData =  Apartment::where('id', Auth::user()->aptId)->first();
            $apartmentData['isAutoReserve'] = 0;
            $apartmentData->save();
            return response()->json([
                'msg'=> 0,
            ]);
        }
    }

    public function delApt(Request $request){
        $id = $request->id;
        return Apartment::where('id',$request->id)->delete();
    }

    public function addSuperMng(Request $request){
        $this->validate($request,[
            'aptName'=>'required',
            'address'=>'required',
            'repreName'=>'required',
            'mngName'=>'required',
            'mngPhoneNumber'=>'required',
            'mngEmail'=>'required',
            'mngId'=>'required',
            'mngPassword'=>'required'
        ]);
        $aptId = $request->id;
        $aptName = $request->aptName;
        $repreName = $request->repreName;
        $mngName = $request->mngName;
        $mngPhoneNumber = $request->mngPhoneNumber;
        $mngEmail = $request->mngEmail;
        $mngId = $request->mngId;
        $mngPassword = $request->mngPassword;

        return User::create([
            'name'=>$mngName,
            'email'=>$mngEmail,
            'password'=>bcrypt($mngPassword),
            'phoneNumber'=>$mngPhoneNumber,
            'roleId'=>2,
            'aptId'=>$aptId
        ]);
    }
}
