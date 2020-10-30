<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repair;
use App\User;

class RepairController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'bail|required',
            'desc' => 'bail|required',
            'type' => 'bail|required',
            'object' => 'bail|required',
        ]);
        $userId = Auth::user()->id;
        $aptId = Auth::user()->aptId;
        $repairData['userId'] = $userId;
        $repairData['aptId'] = $aptId;
        $repairData['title'] = $request->title;
        $repairData['desc'] = $request->desc;
        $repairData['type'] = $request->type;
        $repairData['object'] = $request->object;
        $repairData['upload_file'] = json_encode($request->file);
        if($request->isDraft !== null){
            $repairData['isDraft'] = 1;
        }
        if($request->isShowToProprietor !== false){
            $repairData['isShowToProprietor'] = 1;
        }
        $repair = Repair::create($repairData); 

        return response()->json([
            'repair' => $repair
        ], 201);
    }

    public function index(Request $request){
        return Repair::with(['userId', 'repairId'])
                        ->where([['isDraft','=',0]])
                        ->orderBy('created_at','desc')->paginate(2);
    }

    public function getCurrent(Request $request){
        $userId = Auth::user()->id;
        $id = $request->id;
        $repairData =  Repair::with(['userId', 'repairId'])
                        ->where('id',$id)
                        ->first();
        return response()->json([
            'repairData' => $repairData,
        ], 200);
    }
}
