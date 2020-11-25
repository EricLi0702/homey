<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repair;
use App\ResponseRepair;
use App\User;
use App\RepairType;
use Carbon\Carbon;

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
        if (is_numeric($request->type)) {
            $repairData['isSelectMode'] = 1;
        }
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
        $user = Auth::user();
        if($user->roleId == 2 || $user->roleId == 7){
            return Repair::with(['userId', 'repairId.managerId'])
                            ->where([['isDraft','=',0]])
                            ->where([['aptId','=',$user->aptId]])
                            ->orderBy('created_at','desc')
                            ->paginate(5);

        }
        elseif($user->roleId == 4){
            $resident = User::where([
                ['aptId', '=', $user->aptId],
                ['buildingId', '=', $user->buildingId],
                ['ho', '=', $user->ho],
                ['roleId', '=', 3]
            ])->first();
            if($resident == null){
                return response()->json([
                    'msg' => 0
                ], 200);
            }
            return Repair::with(['userId', 'repairId'])
                                ->where('userId', '=', $resident->id)
                                ->where('isShowToProprietor', '=', 1)
                                ->orderBy('created_at','desc')
                                ->paginate(5);
        }
        else{
            return Repair::with(['userId', 'repairId'])
                            ->where([['isDraft','=',0]])
                            ->where([['aptId','=',$user->aptId]])
                            ->where([['userId','=',$user->id]])
                            ->orderBy('created_at','desc')
                            ->paginate(5);
        }
    }

    public function getCurrent(Request $request){
        $currentUser = Auth::user();
        $userId = $currentUser->id;
        $id = $request->id;
        $repairData =  Repair::with(['userId', 'repairId.managerId', 'repairId.userId'])
                        ->where('id',$id)
                        ->first();
        if($repairData->userId !== $userId){
            $repairDataOfUser = User::where('id', $repairData->userId)->first();
            if($currentUser->roleId == 2 || $currentUser->roleId == 7) {
                return response()->json([
                    'repairData' => $repairData,
                ], 200);
            }
            if($repairDataOfUser->aptId == $currentUser->aptId &&
                $repairDataOfUser->buildingId == $currentUser->buildingId &&
                $repairDataOfUser->ho == $currentUser->ho &&
                $repairDataOfUser->roleId == 3 &&
                $repairData->isShowToProprietor == 1){
                    return response()->json([
                        'repairData' => $repairData,
                    ], 200);
                }
            else{
                return response()->json([
                    'repairData' => 0
                ], 200);
            }
        }
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
            'msg' => "finished successfully!"
        ], 200);
    }
    

    public function getTop5Repair(Request $request){
        $userId = $request->id;
        return Repair::where('userId',$userId)->orderBy('created_at','desc')->take(5)->get();
    }

    public function getRepairCnt(Request $request){
        $weekData = Repair::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $todayData = Repair::whereDate('created_at', Carbon::today())->count();
        $monthData = Repair::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->month)->count();
        $id = Auth::user()->aptId;
        $registerUserCnt = User::where('aptId',$id)->count();
        $currentUserCnt = User::where([['aptId','=',$id],['email_verified_at','<>',null]])->count();
        return response()->json([
            'today'=>$todayData,
            'week'=>$weekData,
            'month'=>$monthData,
            'registerCnt'=>$registerUserCnt,
            'currentCnt'=>$currentUserCnt
        ]);
    }

    public function getFirstItemID()
    {
        return Repair::with('userId')->first();
    }

    public function getLastItemID()
    {
        return Repair::with('userId')->orderBy('id', 'desc')->first();
    }

    public function getPreviousItemID(Request $request)
    {
        $previousItem = Repair::where('id', '<', $request->id)->with('userId')->orderBy('id','desc')->first();
        if($previousItem == null){
            return null;
        }
        else{
            return $previousItem;
        }
    }

    public function getNextItemID(Request $request)
    {
        $nextItem = Repair::where('id', '>', $request->id)->with('userId')->orderBy('id')->first();
        if($nextItem == null){
            return null;
        }
        else{
            return $nextItem;
        }
    }

    public function getRepairType(Request $request){
        return RepairType::where('aptId', Auth::user()->aptId)->get();
        // $userRoleId = Auth::user()->roleId;
        // if($userRoleId !== 2 && $userRoleId !== 7){
        //     return null;
        // }
        // else{
        // }
    }

    public function postRepairType(Request $request)
    {
        $aptId = Auth::user()->aptId;
        $userId = Auth::user()->id;
        $jsonData = json_encode($request->jsonData);
        $lang = $request->lang;
        if($lang == "VN"){
            return RepairType::where([
                ['aptId', '=', $aptId],
                ['lang', '=', 'vn']
            ])->update([
                'userId'=>$userId,
                'aptId'=>$aptId,
                'repair_type'=>$jsonData
            ]);
        }
        if($lang == "EN"){
            return RepairType::where([
                ['aptId', '=', $aptId],
                ['lang', '=', 'en']
            ])->update([
                'userId'=>$userId,
                'aptId'=>$aptId,
                'repair_type'=>$jsonData
            ]);
        }
        if($lang == "KR"){
            return RepairType::where([
                ['aptId', '=', $aptId],
                ['lang', '=', 'kr']
            ])->update([
                'userId'=>$userId,
                'aptId'=>$aptId,
                'repair_type'=>$jsonData
            ]);
        }

        
    }
}
