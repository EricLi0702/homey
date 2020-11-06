<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    /**
     * Get authenticated user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function current(Request $request)
    {
        $userId = Auth::user()->id;
        $res = User::where('id',$userId)->with('role','apt.building')->get();
        return response()->json($res[0]);
    }

    public function userList(Request $request){
        $aptId = $request->id;
        $aptId = $request->aptId;
        return User::where([['aptId','=',$request->aptId],['roleId','>',2]])->with('role','apt','building')->get(); 
    }

    public function addUser(Request $request){
        $this->validate($request,[
            'aptId'=>'required',
            'name'=>'required',
            'email'=>'required',
            'phoneNumber'=>'required',
            'buildingId'=>'required',
            'ho'=>'required',
            'roleId'=>'required'
        ]);
        $roleId = $request->roleId;
        return User::create([
            'aptId'=>$request->aptId,
            'name'=>$request->name,
            'email'=>$request->email,
            'phoneNumber'=>$request->phoneNumber,
            'buildingId'=>$request->buildingId,
            'ho'=>$request->ho,
            'roleId'=>$request->roleId
        ]);
    }

    public function newPush(Request $request)
    {
        $userId = Auth::user()->id;
        $currentUser = User::where('id',$userId)->first();
        $pushData = json_encode($request->postNewPushData);
        $currentUser->newPush = $pushData;
        $currentUser->save();
        return response()->json([
            'pushData' => $pushData,
        ], 200);
    }

    public function getNewPush()
    {
        $userId = Auth::user()->id;
        $currentUser = User::where('id',$userId)->first();
        $pushData = $currentUser->newPush;
        return response()->json([
            'pushData' => $pushData,
        ], 200);
    }

    public function removePushNotification(Request $request){
        $userId = Auth::user()->id;
        $currentUser = User::where('id',$userId)->first();
        $pushData = json_encode($request->postUpdatePushData);
        $currentUser->newPush = $pushData;
        $currentUser->save();
        return response()->json([
            'pushData' => $pushData,
        ], 200);
    }
}
