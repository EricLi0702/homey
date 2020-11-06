<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repair;
use App\ResponseRepair;
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
        if($request->isShowToProprietor == true){
            $repairData['isShowToProprietor'] = 1;
        }
        $repair = Repair::create($repairData); 

        return response()->json([
            'repair' => $repair
        ], 201);
    }

    public function index(Request $request){
        if(Auth::user()->roleId == 2){
            return Repair::with(['userId', 'repairId.managerId'])
                            ->where([['isDraft','=',0]])
                            ->where([['aptId','=',Auth::user()->aptId]])
                            ->orderBy('created_at','desc')
                            ->paginate(2);

        }
        else{
            return Repair::with(['userId', 'repairId'])
                            ->where([['isDraft','=',0]])
                            ->where([['aptId','=',Auth::user()->aptId]])
                            ->where([['userId','=',Auth::user()->id]])
                            ->orderBy('created_at','desc')
                            ->paginate(2);
        }
    }

    public function getCurrent(Request $request){
        $userId = Auth::user()->id;
        $id = $request->id;
        $repairData =  Repair::with(['userId', 'repairId.managerId', 'repairId.userId'])
                        ->where('id',$id)
                        ->first();
        return response()->json([
            'repairData' => $repairData,
        ], 200);
    }

    public function response(Request $request)
    {
        $responseData = $request->responseData;
        $repairData = $request->repairData;

        $updateRepairStatus = Repair::where([['id','=',$repairData['id']]])->first();
        if($updateRepairStatus->status == 'pending'){
            $updateRepairStatus->status = 'approved';
            $updateRepairStatus->save();
        }

        $responseToRepairData = new ResponseRepair;
        $responseToRepairData->userId = Auth::user()->id;
        $responseToRepairData->repairId = $repairData['id'];
        $responseToRepairData->replyToClient = $responseData;
        $responseToRepairData->save();

        return response()->json([
            'responseData' => $responseToRepairData->load(['userId', 'repairId'])
        ], 201);
    }
    
    public function deleteRepair(Request $request){
        $id = $request['id'];
        Repair::where('id',$request->id)->delete();
        ResponseRepair::where('repairId', $request->id)->delete();
        return response()->json([
            'msg' => "removed successfully!"
        ], 204);
    }

    public function finish(Request $request){
        $repairData = $request['repairData'];
        $id = $repairData['id'];
        $rating = $request['rating'];
        $finishRequestData = $request['finishRequestData'];
        $requestedFinishRepairData = Repair::where('id',$id)->first();
        $requestedFinishRepairData->status = "finish";
        $requestedFinishRepairData->star = $rating;
        $requestedFinishRepairData->save();

        $finishRequestRepairData = new ResponseRepair;
        $finishRequestRepairData->userId = $repairData['userId'];
        $finishRequestRepairData->repairId = $repairData['id'];
        $finishRequestRepairData->replyFromClient = $finishRequestData;
        $finishRequestRepairData->save();
        return response()->json([
            'msg' => "removed successfully!"
        ], 200);
    }
    

    public function getTop5Repair(Request $request){
        $userId = $request->id;
        return Repair::where('userId',$userId)->orderBy('created_at','desc')->take(5)->get();
    }
}
