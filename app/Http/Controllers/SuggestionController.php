<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Suggestion;
use App\CommentOfSuggestion;
use App\User;
use App\Events\NewSuggestion;
use Carbon\Carbon;

class SuggestionController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'bail|required',
            'desc' => 'bail|required',
        ]);
        $userId = Auth::user()->id;
        $suggestionData['userId'] = $userId;
        $suggestionData['title'] = $request->title;
        $suggestionData['content'] = $request->desc;
        $suggestionData['upload_file'] = json_encode($request->file);
        if($request->isDraft !== null){
            $suggestionData['isDraft'] = 1;
        }
        $suggestion = Suggestion::create($suggestionData); 

        $broadcastingData['id'] = $suggestion->id;
        $broadcastingData['userId'] = Auth::user()->id;
        $broadcastingData['userName'] = Auth::user()->name;
        $broadcastingData['userAvatar'] = Auth::user()->user_avatar;
        $broadcastingData['title'] = $request->title;
        $broadcastingData['created_at'] = now();

        if($request->isDraft == null){
            // broadcast Event
            broadcast(new NewSuggestion($broadcastingData))->toOthers();
            $userList = User::where([
                ['aptId', '=', Auth::user()->aptId],
                ['id', '<>', Auth::user()->id]
            ])->get();

            foreach ($userList as $key => $user){
                $newPushOfUser = json_decode($user->newPush);
                if($newPushOfUser == null){
                    $willStoreAsNewPush = new \stdClass();
                    $willStoreAsNewPush->suggestion[] = $broadcastingData;
                    $willStoreAsNewPush->notification = [];
                    $willStoreAsNewPush->community = [];
                    $user->newPush = json_encode($willStoreAsNewPush);
                    $user->save();
                }
                else{
                    array_push($newPushOfUser->suggestion, $broadcastingData);
                    $user->newPush = json_encode($newPushOfUser);
                    $user->save();
                }
            }
        }

        return response()->json([
            'suggestion' => $suggestion
        ], 201);
    }

    public function index(Request $request){
        return Suggestion::with('userId')
                        ->where([['isDraft','=',0]])
                        ->orderBy('created_at','desc')->paginate(5);
    }

    public function remove(Request $request)
    {
        if($request->userId !== Auth::user()->id){
            return Suggestion::where('id',$request->id)->update([
                'content' => "removed by Administrator",
                'isRemoved' => 1,
                'upload_file' => json_encode($request->upload_file)
                ]);
            }
            else{
            return Suggestion::where('id',$request->id)->update([
                'content' => "removed by Author",
                'isRemoved' => 1,
                'upload_file' => json_encode($request->upload_file)
            ]);
        }
    }

    public function getCurrent(Request $request){
        $userId = Auth::user()->id;
        $id = $request->id;
        $suggestionData =  Suggestion::with('userId')
                        ->where('id',$id)
                        ->first();
        return response()->json([
            'suggestionData' => $suggestionData,
        ], 200);
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'title' => 'bail|required',
            'content' => 'bail|required',
        ]);
        
        $commentOfRequestedUpdate = CommentOfSuggestion::where([['suId', '=', $request->id]])->get();
        if(sizeof($commentOfRequestedUpdate) == 0){
            $userId = Auth::user()->id;
            $suggestionData['userId'] = $userId;
            $suggestionData['title'] = $request->title;
            $suggestionData['content'] = $request->content;
            $suggestionData['created_at'] = now();
            $suggestionData['upload_file'] = json_encode($request->upload_file);
            
            return Suggestion::where('id',$request->id)->update($suggestionData);
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
        //remove from new push
        $newPushData = json_decode(Auth::user()->newPush);
        if($newPushData !== null){
            foreach ($newPushData->suggestion as $key => $suggestion){
                if($id = $suggestion->id){
                    unset($newPushData->suggestion[$key]);
                }
            }
            $updatedPushDataUser = User::where('id', $userId)->first();
            $updatedPushDataUser['newPush'] = json_encode($newPushData);
            $updatedPushDataUser->save();
        }
        ////////////////////////////////////////////////////////////
        $suggestionData =  Suggestion::with('userId')
                        ->where('id',$id)
                        ->first();
        $currentViewCnt = json_decode($suggestionData->view_cnt);
        if($currentViewCnt == null){
            $currentViewCnt[] = $userId;
            $suggestionData->view_cnt = $currentViewCnt;
            $suggestionData->save();
            return ;
        }
        else{
            if (in_array($userId, $currentViewCnt)) {
                return ;
            }
            else{
                array_push($currentViewCnt, $userId);
                $suggestionData->view_cnt = $currentViewCnt;
                $suggestionData->save();
                return ;
            }
        }
        return ;
    }
    

    public function addHeart(Request $request){
        $userId = Auth::user()->id;
        $suggestionId = $request->id;
        $suggestionData = Suggestion::where('id', $suggestionId)->first();
        $currentHeartCnt = json_decode($suggestionData->heart_cnt);
        if($currentHeartCnt == null){
            $currentHeartCnt[] = $userId;
            $suggestionData->heart_cnt = $currentHeartCnt;
            $suggestionData->save();
            return $currentHeartCnt;
        }
        else{
            if (in_array($userId, $currentHeartCnt)) {
                return $currentHeartCnt;
            }
            else{
                array_push($currentHeartCnt, $userId);
                $suggestionData->heart_cnt = $currentHeartCnt;
                $suggestionData->save();
                return $currentHeartCnt;
            }
        }
    }
    public function addLike(Request $request){
        $userId = Auth::user()->id;
        $suggestionId = $request->id;
        $suggestionData = Suggestion::where('id', $suggestionId)->first();
        $currentLikeCnt = json_decode($suggestionData->like_cnt);
        if($currentLikeCnt == null){
            $currentLikeCnt[] = $userId;
            $suggestionData->like_cnt = $currentLikeCnt;
            $suggestionData->save();
            return $currentLikeCnt;
        }
        else{
            if (in_array($userId, $currentLikeCnt)) {
                return $currentLikeCnt;
            }
            else{
                array_push($currentLikeCnt, $userId);
                $suggestionData->like_cnt = $currentLikeCnt;
                $suggestionData->save();
                return $currentLikeCnt;
            }
        }
    }

    public function addDislike(Request $request){
        $userId = Auth::user()->id;
        $suggestionId = $request->id;
        $suggestionData = Suggestion::where('id', $suggestionId)->first();
        $currentDislikeCnt = json_decode($suggestionData->dislike_cnt);
        if($currentDislikeCnt == null){
            $currentDislikeCnt[] = $userId;
            $suggestionData->dislike_cnt = $currentDislikeCnt;
            $suggestionData->save();
            return $currentDislikeCnt;
        }
        else{
            if (in_array($userId, $currentDislikeCnt)) {
                return $currentDislikeCnt;
            }
            else{
                array_push($currentDislikeCnt, $userId);
                $suggestionData->dislike_cnt = $currentDislikeCnt;
                $suggestionData->save();
                return $currentDislikeCnt;
            }
        }
    }
    

    public function removeHeart(Request $request){
        $userId = Auth::user()->id;
        $suggestionId = $request->id;
        $suggestionData = Suggestion::where('id', $suggestionId)->first();
        $currentHeartCnt = json_decode($suggestionData->heart_cnt);
        if( sizeof($currentHeartCnt) == 1 && $currentHeartCnt[0] == $userId){
            $currentHeartCnt = null;
            $suggestionData->heart_cnt = $currentHeartCnt;
            $suggestionData->save();
        }
        else{
            if (($key = array_search($userId, $currentHeartCnt)) !== false) {
                unset($currentHeartCnt[$key]);
            }
            $suggestionData->heart_cnt = $currentHeartCnt;
            $suggestionData->save();
            return $currentHeartCnt;
        }
    }

    public function removeLike(Request $request){
        $userId = Auth::user()->id;
        $suggestionId = $request->id;
        $suggestionData = Suggestion::where('id', $suggestionId)->first();
        $currentLikeCnt = json_decode($suggestionData->like_cnt);
        if( sizeof($currentLikeCnt) == 1 && $currentLikeCnt[0] == $userId){
            $currentLikeCnt = null;
            $suggestionData->like_cnt = $currentLikeCnt;
            $suggestionData->save();
        }
        else{
            if (($key = array_search($userId, $currentLikeCnt)) !== false) {
                unset($currentLikeCnt[$key]);
            }
            $suggestionData->like_cnt = $currentLikeCnt;
            $suggestionData->save();
            return $currentLikeCnt;
        }
    }

    public function removeDislike(Request $request){
        $userId = Auth::user()->id;
        $suggestionId = $request->id;
        $suggestionData = Suggestion::where('id', $suggestionId)->first();
        $currentDislikeCnt = json_decode($suggestionData->dislike_cnt);
        if( sizeof($currentDislikeCnt) == 1 && $currentDislikeCnt[0] == $userId){
            $currentDislikeCnt = null;
            $suggestionData->dislike_cnt = $currentDislikeCnt;
            $suggestionData->save();
        }
        else{
            if (($key = array_search($userId, $currentDislikeCnt)) !== false) {
                unset($currentDislikeCnt[$key]);
            }
            $suggestionData->dislike_cnt = $currentDislikeCnt;
            $suggestionData->save();
            return $currentDislikeCnt;
        }
    }

    public function getTop5Suggestion(Request $request){
        $userId = $request->id;
        return Suggestion::where('userId',$userId)->orderBy('created_at','desc')->take(5)->get();
    }

    public function getSuggestionCnt(Request $request){
        $weekData = Suggestion::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $todayData = Suggestion::whereDate('created_at', Carbon::today())->count();
        $monthData = Suggestion::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->month)->count();
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
        return Suggestion::with('userId')->first();
    }

    public function getLastItemID()
    {
        return Suggestion::with('userId')->orderBy('id', 'desc')->first();
    }

    public function getPreviousItemID(Request $request)
    {
        $previousItem = Suggestion::where('id', '<', $request->id)->orderBy('id','desc')->with('userId')->first();
        if($previousItem == null){
            return null;
        }
        else{
            return $previousItem;
        }
    }

    public function getNextItemID(Request $request)
    {
        $nextItem = Suggestion::where('id', '>', $request->id)->with('userId')->orderBy('id')->first();
        if($nextItem == null){
            return null;
        }
        else{
            return $nextItem;
        }
    }
}
