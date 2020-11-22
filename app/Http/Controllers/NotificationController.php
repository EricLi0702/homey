<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;
use App\Notification;
use App\User;
use App\Events\NewNotification;
use Carbon\Carbon;
class NotificationController extends Controller
{
    public function store(Request $request) 
    {
        $this->validate($request,[
            'title' => 'bail|required',
            'desc' => 'bail|required',
            'type' => 'bail|required',
            'period' => 'bail|required'
        ]);

        
        if (isset($request->id)){
            $Id = $request->id;
            Notification::where('id', $request->id)->delete();
        }
        
        $userId = Auth::user()->id;
        $aptId = Auth::user()->aptId;
        $notificationData['userId'] = $userId;
        $notificationData['aptId'] = $aptId;
        $notificationData['title'] = $request->title;
        $notificationData['content'] = $request->desc;
        $notificationData['type'] = $request->type;
        $notificationData['upload_file'] = json_encode($request->file);
        if(is_array($request->period)){
            $notificationData['periodFrom'] = $request->period[0];
            $notificationData['periodTo'] = $request->period[1];
            //get period from StartTime to EndTime
            $from = new DateTime($request->period[0]);
            $to = new DateTime($request->period[1]);
            $calcPeriod = date_diff($from, $to)->days;
            $notificationData['period'] = $calcPeriod;
            //set status of notification by comparing now and StartTime
            $nowTime = new DateTime(date("Y-m-d H:i:s"));
            // $pieces = explode(" ", $from->date);
            if ( $from > $nowTime) 
                    $notificationData['status'] = "before";
                else
                    $notificationData['status'] = "ongoing";
        } else{
            $notificationData['period'] = $request->period;
            if($request->period == "forever"){
                $nowTime = date("Y-m-d H:i:s");
                $notificationData['periodFrom'] = $nowTime;
            }
            elseif($request->period == "week"){
                $nowTime = date("Y-m-d H:i:s");
                $endTime = date('Y-m-d H:i:s', strtotime($nowTime. ' + 7 days'));
                $notificationData['periodFrom'] = $nowTime;
                $notificationData['periodTo'] = $endTime;
            }
            elseif($request->period == "month"){
                $nowTime = date("Y-m-d H:i:s");
                $endTime = date('Y-m-d H:i:s', strtotime($nowTime. ' + 30 days'));
                $notificationData['periodFrom'] = $nowTime;
                $notificationData['periodTo'] = $endTime;
            }
        }

        if($request->isDraft !== null){
            $draftData = Notification::where([
                ['userId', '=', Auth::user()->id],
                ['isDraft', '=', 1]
            ])->first();
            if($draftData == null){
                $notificationData['isDraft'] = 1;
                $notificationData['status'] = "before";
                $notification = Notification::create($notificationData); 
                return response()->json([
                    'notification' => $notification
                ], 201);
            }
            else{
                $draftData->title = $notificationData['title'];
                $draftData->content = $notificationData['content'];
                $draftData->type = $notificationData['type'];
                $draftData->upload_file = $notificationData['upload_file'];
                $draftData->isDraft = 1;
                $draftData->status = "before";
                $draftData->save();
                return response()->json([
                    'notification' => $draftData
                ], 201);
            }
        }

        $notification = Notification::create($notificationData); 

        $broadcastingData['id'] = $notification->id;
        $broadcastingData['userId'] = Auth::user()->id;
        $broadcastingData['userName'] = Auth::user()->name;
        $broadcastingData['userAvatar'] = Auth::user()->user_avatar;
        $broadcastingData['title'] = $request->title;
        $broadcastingData['type'] = $request->type;
        $broadcastingData['created_at'] = now();

        if($request->isDraft == null){
            // broadcast Event
            broadcast(new NewNotification($broadcastingData))->toOthers();

            $userList = User::where([
                ['aptId', '=', Auth::user()->aptId],
                ['id', '<>', Auth::user()->id]
            ])->get();

            foreach ($userList as $key => $user){
                $newPushOfUser = json_decode($user->newPush);
                if($newPushOfUser == null){
                    $willStoreAsNewPush = new \stdClass();
                    $willStoreAsNewPush->notification[] = $broadcastingData;
                    // array_push($willStoreAsNewPush->notification, $broadcastingData);
                    $willStoreAsNewPush->suggestion = [];
                    $willStoreAsNewPush->community = [];
                    $user->newPush = json_encode($willStoreAsNewPush);
                    $user->save();
                }
                else{
                    array_push($newPushOfUser->notification, $broadcastingData);
                    $user->newPush = json_encode($newPushOfUser);
                    $user->save();
                }
            }
        }

        return response()->json([
            'notification' => $notification
        ], 201);
    }

    public function index(Request $request){
        
        $aptId = Auth::user()->aptId;
        if (Auth::user()->roleId == 2 || Auth::user()->roleId == 6){
            return Notification::where([['aptId','=',$aptId]])
                            ->where([['isDraft','=',0]])
                            ->with('userId')
                            ->orderBy('created_at','desc')->paginate(5);
        }
        else{
            return Notification::where([['status','=','ongoing']])
                                ->where([['aptId','=',$aptId]])
                                ->where([['isDraft','=',0]])
                                ->where([['isDowngrade','=',0]])
                                ->with('userId')
                                ->orderBy('created_at','desc')->paginate(5);
        }
    }

    public function indexDowngrade(Request $request){
        $aptId = Auth::user()->aptId;
        return Notification::where([['isDowngrade','=',1], ['aptId', '=', $aptId]])
                            ->with('userId')
                            ->orderBy('created_at','desc')->paginate(5);
    }

    public function delete(Request $request){
        $id = $request->id;
        return Notification::where('id',$request->id)->delete();
    }

    public function getCurrent(Request $request){
        $userId = Auth::user()->id;
        $id = $request->id;
        $notificationData =  Notification::with('userId')
                        ->where('id',$id)
                        ->first();
        return response()->json([
            'notificationData' => $notificationData,
        ], 200);
    }

    public function addView(Request $request)
    {   
        $userId = Auth::user()->id;
        $id = $request->id;
        //remove from new push
        $newPushData = json_decode(Auth::user()->newPush);
        if($newPushData !== null){
            foreach ($newPushData->notification as $key => $notification){
                if($id = $notification->id){
                    unset($newPushData->notification[$key]);
                }
            }
            $updatedPushDataUser = User::where('id', $userId)->first();
            $updatedPushDataUser['newPush'] = json_encode($newPushData);
            $updatedPushDataUser->save();
        }
        ////////////////////////////////////////////////////////////
        $notificationData =  Notification::with('userId')
                        ->where('id',$id)
                        ->first();
        $currentViewCnt = json_decode($notificationData->view_cnt);
        if($currentViewCnt == null){
            $currentViewCnt[] = $userId;
            $notificationData->view_cnt = $currentViewCnt;
            $notificationData->save();
            return ;
        }
        else{
            if (in_array($userId, $currentViewCnt)) {
                return ;
            }
            else{
                array_push($currentViewCnt, $userId);
                $notificationData->view_cnt = $currentViewCnt;
                $notificationData->save();
                return ;
            }
        }
        return ;
    }


    public function update(Request $request)
    {   
        $this->validate($request,[
            'title' => 'bail|required',
            'content' => 'bail|required',
            'type' => 'bail|required',
            'period' => 'bail|required'
        ]);
        
        $userId = Auth::user()->id;
        $aptId = Auth::user()->aptId;
        $notificationData['userId'] = $userId;
        $notificationData['aptId'] = $aptId;
        $notificationData['title'] = $request->title;
        $notificationData['content'] = $request->content;
        $notificationData['type'] = $request->type;
        $notificationData['created_at'] = now();
        $notificationData['upload_file'] = json_encode($request->upload_file);
        if(is_array($request->period)){
            $notificationData['periodFrom'] = $request->period[0];
            $notificationData['periodTo'] = $request->period[1];
            //get period from StartTime to EndTime
            $from = new DateTime($request->period[0]);
            $to = new DateTime($request->period[1]);
            $calcPeriod = date_diff($from, $to)->days;
            $notificationData['period'] = $calcPeriod;
            //set status of notification by comparing now and StartTime
            $nowTime = new DateTime(date("Y-m-d H:i:s"));
            // $pieces = explode(" ", $from->date);
            if ( $from > $nowTime) 
                    $notificationData['status'] = "before";
                else
                    $notificationData['status'] = "ongoing";
        } else{
            $notificationData['period'] = $request->period;
            if($request->period == "forever"){
                $nowTime = new DateTime(date("Y-m-d H:i:s"));
                $notificationData['periodFrom'] = $nowTime;
            }
            elseif($request->period == "week"){
                $nowTime = new DateTime(date("Y-m-d H:i:s"));
                $endTime = date('Y-m-d', strtotime($nowTime. ' + 7 days'));
                $notificationData['periodFrom'] = $nowTime;
                $notificationData['periodTo'] = $endTime;
            }
            elseif($request->period == "month"){
                $nowTime = new DateTime(date("Y-m-d H:i:s"));
                $endTime = date('Y-m-d', strtotime($nowTime. ' + 30 days'));
                $notificationData['periodFrom'] = $nowTime;
                $notificationData['periodTo'] = $endTime;
            }
        }

        if($request->isDraft == 0){
            $notificationData['isDraft'] = 0;
        }elseif($request->isDraft == 1){
            $notificationData['isDraft'] = 1;
        }

        return Notification::where('id',$request->id)->update($notificationData);
    }

    public function downgrade(Request $request)
    {
        return Notification::where('id',$request->id)->update([
            'isDowngrade' => 1
        ]);
    }

    public function upgrade(Request $request)
    {   
        return Notification::where('id',$request->id)->update([
            'isDowngrade' => 0,
            'created_at' => now()
        ]);
    }

    public function getTop5Notification(Request $request){
        $userId = $request->id;
        return Notification::where('userId',$userId)->orderBy('created_at','desc')->take(5)->get();
    }

    public function getNotificationCnt(Request $request){
        $today = Carbon::today();
        $weekData = Notification::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $todayData = Notification::whereDate('created_at', Carbon::today())->count();
        $monthData = Notification::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->month)->count();
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
        $Id = Notification::with('userId')->first();
        return $Id;
    }

    public function getLastItemID()
    {
        $Id = Notification::with('userId')->orderBy('id', 'desc')->first();
        return $Id;
    }

    public function getPreviousItemID(Request $request)
    {
        $previousItem = Notification::where('id', '<', $request->id)->orderBy('id','desc')->with('userId')->first();
        if($previousItem == null){
            return null;
        }
        else{
            return $previousItem;
        }
    }

    public function getNextItemID(Request $request)
    {
        $nextItem = Notification::where('id', '>', $request->id)->with('userId')->orderBy('id')->first();
        if($nextItem == null){
            return null;
        }
        else{
            return $nextItem;
        }
    }

    public function getDraft(Request $request){
        $draftData = Notification::where([
            ['userId', '=', Auth::user()->id],
            ['isDraft', '=', 1]
        ])->get();
        
        if($draftData == null){
            return response()->json([
                'draftData' => null
            ], 200);
        }
        else{
            return response()->json([
                'draftData' => $draftData
            ], 200);
        }
    }
}
