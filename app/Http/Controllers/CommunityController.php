<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;
use App\User;
use App\Community;
use App\CommentOfCommunity;
use Carbon\Carbon;
use App\Events\NewCommunity;


class CommunityController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'bail|required',
            'desc' => 'bail|required',
            'period' => 'bail|required'
        ]);
        $userId = Auth::user()->id;
        $aptId = Auth::user()->aptId;
        $communityData['userId'] = $userId;
        $communityData['aptId'] = $aptId;
        $communityData['title'] = $request->title;
        $communityData['content'] = $request->desc;
        $communityData['upload_file'] = json_encode($request->upload_file);

        if(is_array($request->period)){
            $communityData['periodFrom'] = $request->period[0];
            $communityData['periodTo'] = $request->period[1];
            //get period from StartTime to EndTime
            $from = new DateTime($request->period[0]);
            $to = new DateTime($request->period[1]);
            $calcPeriod = date_diff($from, $to)->days;
            $communityData['period'] = $calcPeriod;
            //set status of notification by comparing now and StartTime
            $nowTime = new DateTime(date("Y-m-d H:i:s"));
            // $pieces = explode(" ", $from->date);
            if ( $from > $nowTime) 
                    $communityData['status'] = "before";
                else
                    $communityData['status'] = "ongoing";
        } else{
            $communityData['period'] = $request->period;
            if($request->period == "forever"){
                $nowTime = date("Y-m-d H:i:s");
                $communityData['periodFrom'] = $nowTime;
            }
            elseif($request->period == "week"){
                $nowTime = date("Y-m-d H:i:s");
                $endTime = date('Y-m-d H:i:s', strtotime($nowTime. ' + 7 days'));
                $communityData['periodFrom'] = $nowTime;
                $communityData['periodTo'] = $endTime;
            }
            elseif($request->period == "month"){
                $nowTime = date("Y-m-d H:i:s");
                $endTime = date('Y-m-d H:i:s', strtotime($nowTime. ' + 30 days'));
                $communityData['periodFrom'] = $nowTime;
                $communityData['periodTo'] = $endTime;
            }
        }
        $community = Community::create($communityData); 

        $broadcastingData['id'] = $community->id;
        $broadcastingData['userId'] = Auth::user()->id;
        $broadcastingData['userName'] = Auth::user()->name;
        $broadcastingData['userAvatar'] = Auth::user()->user_avatar;
        $broadcastingData['title'] = $request->title;
        $broadcastingData['created_at'] = now();

        broadcast(new NewCommunity($broadcastingData))->toOthers();
        $userList = User::where([
            ['aptId', '=', Auth::user()->aptId],
            ['id', '<>', Auth::user()->id]
        ])->get();

        foreach ($userList as $key => $user){
            $newPushOfUser = json_decode($user->newPush);
            if($newPushOfUser == null){
                $willStoreAsNewPush = new \stdClass();
                $willStoreAsNewPush->community[] = $broadcastingData;
                // array_push($willStoreAsNewPush->notification, $broadcastingData);
                $willStoreAsNewPush->suggestion = [];
                $willStoreAsNewPush->notification = [];
                $user->newPush = json_encode($willStoreAsNewPush);
                $user->save();
            }
            else{
                array_push($newPushOfUser->community, $broadcastingData);
                $user->newPush = json_encode($newPushOfUser);
                $user->save();
            }
        }

        return response()->json([
            'community' => $community
        ], 201);
    }

    public function index(Request $request){
        return Community::with('userId')
                        ->where([['aptId', '=', Auth::user()->aptId]])
                        ->where([['status', '=', 'ongoing']])
                        ->orderBy('created_at','desc')->paginate(5);
    }

    public function getCurrent(Request $request){
        $userId = Auth::user()->id;
        $id = $request->id;
        $communityData =  Community::with('userId')
                        ->where('id',$id)
                        ->first();
        return response()->json([
            'communityData' => $communityData,
        ], 200);
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'title' => 'bail|required',
            'content' => 'bail|required',
            'period' => 'bail|required'
        ]);
        
        $commentOfRequestedUpdate = CommentOfCommunity::where([['coId', '=', $request->id]])->get();
        if(sizeof($commentOfRequestedUpdate) == 0){
            $userId = Auth::user()->id;
            $aptId = Auth::user()->aptId;
            $communityData['userId'] = $userId;
            $communityData['aptId'] = $aptId;
            $communityData['title'] = $request->title;
            $communityData['content'] = $request->content;
            $communityData['created_at'] = now();
            $communityData['upload_file'] = json_encode($request->upload_file);

            if(is_array($request->period)){
                $communityData['periodFrom'] = $request->period[0];
                $communityData['periodTo'] = $request->period[1];
                //get period from StartTime to EndTime
                $from = new DateTime($request->period[0]);
                $to = new DateTime($request->period[1]);
                $calcPeriod = date_diff($from, $to)->days;
                $communityData['period'] = $calcPeriod;
                //set status of notification by comparing now and StartTime
                $nowTime = new DateTime(date("Y-m-d H:i:s"));
                // $pieces = explode(" ", $from->date);
                if ( $from > $nowTime) 
                        $communityData['status'] = "before";
                    else
                        $communityData['status'] = "ongoing";
            } else{
                $communityData['period'] = $request->period;
                if($request->period == "forever"){
                    $nowTime = date("Y-m-d H:i:s");
                    $communityData['periodFrom'] = $nowTime;
                }
                elseif($request->period == "week"){
                    $nowTime = date("Y-m-d H:i:s");
                    $endTime = date('Y-m-d H:i:s', strtotime($nowTime. ' + 7 days'));
                    $communityData['periodFrom'] = $nowTime;
                    $communityData['periodTo'] = $endTime;
                }
                elseif($request->period == "month"){
                    $nowTime = date("Y-m-d H:i:s");
                    $endTime = date('Y-m-d H:i:s', strtotime($nowTime. ' + 30 days'));
                    $communityData['periodFrom'] = $nowTime;
                    $communityData['periodTo'] = $endTime;
                }
            }
            return Community::where('id',$request->id)->update($communityData);
        }
        else{
            return response()->json([
                'msg' => "You can no longer update your Community.",
            ], 423);
        }
    }

    public function addView(Request $request)
    {   
        $userId = Auth::user()->id;
        $id = $request->id;
        //remove from new push
        $newPushData = json_decode(Auth::user()->newPush);
        if($newPushData !== null){
            foreach ($newPushData->community as $key => $community){
                if($id = $community->id){
                    unset($newPushData->community[$key]);
                }
            }
            $updatedPushDataUser = User::where('id', $userId)->first();
            $updatedPushDataUser['newPush'] = json_encode($newPushData);
            $updatedPushDataUser->save();
        }
        ////////////////////////////////////////////////////////////
        $communityData =  Community::with('userId')
                        ->where('id',$id)
                        ->first();
        $currentViewCnt = json_decode($communityData->view_cnt);
        if($currentViewCnt == null){
            $currentViewCnt[] = $userId;
            $communityData->view_cnt = $currentViewCnt;
            $communityData->save();
            return ;
        }
        else{
            if (in_array($userId, $currentViewCnt)) {
                return ;
            }
            else{
                array_push($currentViewCnt, $userId);
                $communityData->view_cnt = $currentViewCnt;
                $communityData->save();
                return ;
            }
        }
        return ;
    }

    public function remove(Request $request)
    {
        if($request->userId !== Auth::user()->id){
            return Community::where('id',$request->id)->update([
                'content' => "removed by Administrator",
                'isRemoved' => 1,
                'upload_file' => json_encode($request->upload_file)
                ]);
            }
            else{
            return Community::where('id',$request->id)->update([
                'content' => "removed by Author",
                'isRemoved' => 1,
                'upload_file' => json_encode($request->upload_file)
            ]);
        }
    }

    public function getTop5Coummunity(Request $request){
        $userId = $request->id;
        return Community::where('userId',$userId)->orderBy('created_at','desc')->take(5)->get();
    }

    public function getCommunityCnt(Request $request){
        $today = Carbon::today();
        $weekData = Community::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $todayData = Community::whereDate('created_at', Carbon::today())->count();
        $monthData = Community::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->month)->count();
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
        return Community::with('userId')->first();
    }

    public function getLastItemID()
    {
        return Community::with('userId')->orderBy('id', 'desc')->first();
    }

    public function getPreviousItemID(Request $request)
    {
        $previousItem = Community::where('id', '<', $request->id)->with('userId')->orderBy('id','desc')->first();
        if($previousItem == null){
            return null;
        }
        else{
            return $previousItem;
        }
    }

    public function getNextItemID(Request $request)
    {
        $nextItem = Community::where('id', '>', $request->id)->with('userId')->orderBy('id')->first();
        if($nextItem == null){
            return null;
        }
        else{
            return $nextItem;
        }
    }
}
