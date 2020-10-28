<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserRole;
class UserRoleController extends Controller
{
    //
    public function getUserRoleList(Request $request){
        return UserRole::all();
    }

    public function addUserRole(Request $request){
        $name = $request->roleName;
        $per = $request->permission;
        $this->validate($request,[
            'roleName' => 'required'
        ]);
        $permission = json_encode($request->permission);
        return UserRole::create([
            'roleName'=>$request->roleName,
            'permission'=>$permission
        ]);
    }

    public function updateUserRole(Request $request){
        $roleId = $request->id;
        $roleName = $request->roleName;
        return UserRole::where('id',$roleId)->update(['roleName'=>$roleName]);
    }

    public function delUserRole(Request $request){
        $roleId = $request->id;
        return UserRole::where('id',$roleId)->delete();
    }
}
