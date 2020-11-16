<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Laravolt\Avatar\Avatar;
use DateTime;

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
        // $aptId = $request->id;
        // $aptId = $request->aptId;
        return User::where([['aptId','=',Auth::user()->aptId],['roleId','>',2]])->with('role','apt','building')->paginate(7); 
    }

    public function adminUserList(Request $request){
        $aptId = $request->aptId;
        $commonUserData = User::where([
            ['aptId','=',$aptId],
            ['roleId','<>',1],
            ['roleId','<>',2],
            ['roleId','<>',6],
            ['roleId','<>',7],
        ])->with('role','apt','building')->paginate(7); 
        $superManagerData = User::where([
            ['aptId','=',$aptId],
            ['roleId','=',2]
        ])->with('role','apt','building')->get(); 
        $notiManagerData = User::where([
            ['aptId','=',$aptId],
            ['roleId','=',6]
        ])->with('role','apt','building')->get(); 
        $repairManagerData = User::where([
            ['aptId','=',$aptId],
            ['roleId','=',7]
        ])->with('role','apt','building')->get(); 

        return response()->json([
            'commonUserData' => $commonUserData,
            'superManagerData' => $superManagerData,
            'notiManagerData' => $notiManagerData,
            'repairManagerData' => $repairManagerData
        ], 200); 
        
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
        if (User::where('email', '=', $request->email)->exists()) {
            return response()->json([
                'isMail' => false
            ], 422);
        }
        
        if (User::where('phoneNumber', '=', $request->phoneNumber)->exists()) {
            return response()->json([
                'isPhone' => false
            ], 422);
        }
        $roleId = $request->roleId;
        $buildingId = $request->buildingId;
        $user =  User::create([
            'aptId'=>$request->aptId,
            'name'=>$request->name,
            'email'=>$request->email,
            'phoneNumber'=>$request->phoneNumber,
            'buildingId'=>$request->buildingId,
            'ho'=>$request->ho,
            'roleId'=>$request->roleId
        ]);

        //set avatar
        $name = date('YmdHis') . ".png";
        $destinationPath = ('/uploads/avatar/user/'); 
        $avatar = new Avatar;
        $avatarImage = $avatar->create($request->email)->toBase64();
        $avatarImage->save(public_path('/uploads/avatar/user/'.$name), $quality = 90);
        $user['user_avatar'] = $destinationPath.$name;
        $user->save();

        return response()->json([
            'msg' => "created"
        ], 201);
    }

    public function delUser(Request $request){
        $id = $request->id;
        return User::where('id',$request->id)->delete();
    }

    public function updateUser(Request $request)
    {
        $this->validate($request,[
            'aptId'=>'required',
            'name'=>'required',
            'email'=>'required',
            'phoneNumber'=>'required',
            'buildingId'=>'required',
            'ho'=>'required',
            'roleId'=>'required'
        ]);
        
        if (User::where([['email', '=', $request->email], ['id', '<>', $request->id]])->exists()) {
            return response()->json([
                'isMail' => false
            ], 422);
        }
        
        if (User::where([['phoneNumber', '=', $request->phoneNumber], ['id', '<>', $request->id]])->exists()) {
            return response()->json([
                'isPhone' => false
            ], 422);
        }
        $roleId = $request->roleId;
        $buildingId = $request->buildingId;
        $user =  User::where('id', $request->id)->update([
            'aptId'=>$request->aptId,
            'name'=>$request->name,
            'email'=>$request->email,
            'phoneNumber'=>$request->phoneNumber,
            'buildingId'=>$request->buildingId,
            'ho'=>$request->ho,
            'roleId'=>$request->roleId
        ]);

        return response()->json([
            'msg' => "updated"
        ], 201);
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
