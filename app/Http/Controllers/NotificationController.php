<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;
use App\Notification;
use App\User;
use App\Events\NewNotification;

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
        $notificationData['userId'] = $userId;
        $notificationData['title'] = $request->title;
        $notificationData['content'] = $request->desc;
        $notificationData['type'] = json_encode($request->type);
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
        $notification = Notification::create($notificationData); 
        
        // broadcast Event
        broadcast(new NewNotification($notification->load('userId')))->toOthers();

        return response()->json([
            'notification' => $notification
        ], 201);
    }

    public function index(Request $request){
        return Notification::where([['status','=','ongoing']])
                            ->where([['isDraft','=',0]])
                            ->where([['isDowngrade','=',0]])
                            ->with('userId')
                            ->orderBy('created_at','desc')->paginate(2);
    }

    // public function index(Request $request){
    //     return Notification::all();
    // }
}
