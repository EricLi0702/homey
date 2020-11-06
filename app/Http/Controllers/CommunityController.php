<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;
use App\User;
use App\Community;
use App\CommentOfCommunity;
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
        
        broadcast(new NewCommunity($community))->toOthers();

        return response()->json([
            'community' => $community
        ], 201);
    }

    public function index(Request $request){
        return Community::with('userId')
                        ->where([['aptId', '=', Auth::user()->aptId]])
                        ->where([['status', '=', 'ongoing']])
                        ->orderBy('updated_at','desc')->paginate(2);
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
                'msg' => "You can no longer update your suggestion.",
            ], 423);
        }
    }

    public function addView(Request $request)
    {   
        $userId = Auth::user()->id;
        $id = $request->id;
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

}
