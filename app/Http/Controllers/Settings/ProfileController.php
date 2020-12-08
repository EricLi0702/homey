<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        return tap($user)->update($request->only('name', 'email'));
    }

    public function updateAvatar(Request $request){
        $imgUrl = $request->imgPath;
        $user = Auth::user();
        $user['user_avatar'] = $imgUrl;
        $user->save();
        return response()->json([
            'msg' => 1,
        ], 200);
    }

    public function updatePass(Request $request){
        $newPassword = $request->newPassword;
        $user = Auth::user();
        $user['password'] = bcrypt($newPassword);
        $user->save();
        return response()->json([
            'msg'=> 1,
        ]);
    }

    public function updateName(Request $request){
        $newName = $request->newName;
        $user = Auth::user();
        $user['name'] = $newName;
        $user->save();
        return response()->json([
            'msg'=> 1,
        ]);
    }
}
