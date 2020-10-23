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
        $res = User::where('id',$userId)->with('role')->get();
        return response()->json($res[0]);
    }

    public function userList(Request $request){
        return User::all(); 
    }
}
