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
        
        $userId = Auth::user()->id;
        $aptId = Auth::user()->aptId;
        $notificationData['userId'] = $userId;
        $notificationData['aptId'] = $aptId;
        $notificationData['title'] = $request->title;
        $notificationData['content'] = $request->desc;
        $notificationData['type'] = json_encode($request->type);
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
            $nowTime = date("Y-m-d");
            $pieces = explode(" ", $from->date);
            if ( $pieces[0] > $nowTime) 
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
            $notificationData['isDraft'] = 1;
        }
        $notification = Notification::create($notificationData); 
        

        if($request->isDraft == null){
            // broadcast Event
            broadcast(new NewNotification($notification))->toOthers();
        }

        return response()->json([
            'notification' => $notification
        ], 201);
    }

    public function index(Request $request){
        $aptId = Auth::user()->aptId;
        return Notification::where([['status','=','ongoing']])
                            ->where([['aptId','=',$aptId]])
                            ->where([['isDraft','=',0]])
                            ->where([['isDowngrade','=',0]])
                            ->with('userId')
                            ->orderBy('updated_at','desc')->paginate(2);
    }

    public function indexDowngrade(Request $request){
        $aptId = Auth::user()->aptId;
        return Notification::where([['isDowngrade','=',1]])
                            ->with('userId')
                            ->orderBy('updated_at','desc')->paginate(2);
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
        $notificationData['type'] = json_encode($request->type);
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
            $nowTime = date("Y-m-d");
            $pieces = explode(" ", $from->date);
            if ( $pieces[0] > $nowTime) 
                    $notificationData['status'] = "before";
                else
                    $notificationData['status'] = "ongoing";
        } else{
            $notificationData['period'] = $request->period;
            if($request->period == "forever"){
                $nowTime = date("Y-m-d");
                $notificationData['periodFrom'] = $nowTime;
            }
            elseif($request->period == "week"){
                $nowTime = date("Y-m-d");
                $endTime = date('Y-m-d', strtotime($nowTime. ' + 7 days'));
                $notificationData['periodFrom'] = $nowTime;
                $notificationData['periodTo'] = $endTime;
            }
            elseif($request->period == "month"){
                $nowTime = date("Y-m-d");
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
            'isDowngrade' => 0
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
        $firstWeek = Carbon::today()->subDays(7);
        $secondWeek = Carbon::today()->subDays(14);
        $thirdWeek = Carbon::today()->subDays(21);
        $forthWeek = Carbon::today()->subDays(28);
        $firstData = Notification::where('created_at','>=',$firstWeek)->count();
        $secondData = Notification::where('created_at','>=',$secondWeek)->count();
        $thirdData = Notification::where('created_at','>=',$thirdWeek)->count();
        $forthData = Notification::where('created_at','>=',$forthWeek)->count();
        return response()->json([
            'today'=>$todayData,
            'week'=>$weekData,
            'firstWeek'=>$firstData,
            'secondWeek'=>$secondData,
            'thirdWeek'=>$thirdData,
            'forthWeek'=>$forthData,
            'month'=>$monthData
        ]);
    }
}
