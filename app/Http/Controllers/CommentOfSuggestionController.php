<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\CommentOfSuggestion;
use App\Suggestion;

class CommentOfSuggestionController extends Controller
{
    public function leaveComment(Request $request)
    {
        $commentData = $request->commentData;
        $suggestionData = $request->suggestionData;
        $currentSuggestionId = $suggestionData['id'];
        $userId = Auth::user()->id;
        $comment['userId'] = $userId;
        $comment['suId'] = $currentSuggestionId;
        $comment['content'] = $commentData;
        $commentToSuggest = CommentOfSuggestion::create($comment); 

        $currentSuggestion = Suggestion::where('id', $currentSuggestionId)->first();
        $currentCommentCnt = json_decode($currentSuggestion->comment_cnt);
        if($currentCommentCnt == null){
            $currentCommentCnt[] = $userId;
            $currentSuggestion->comment_cnt = $currentCommentCnt;
            $currentSuggestion->save();
            return response()->json([
                'commentToSuggest' => $commentToSuggest
            ], 201);
        }
        else{
            if (in_array($userId, $currentCommentCnt)) {
                return response()->json([
                    'commentToSuggest' => $commentToSuggest
                ], 201);
            }
            else{
                array_push($currentCommentCnt, $userId);
                $currentSuggestion->comment_cnt = $currentCommentCnt;
                $currentSuggestion->save();
                return response()->json([
                    'commentToSuggest' => $commentToSuggest
                ], 201);
            }
        }
        return response()->json([
            'commentToSuggest' => $commentToSuggest
        ], 201);
    }

    public function getComment(Request $request)
    {
        $userId = Auth::user()->id;
        $id = $request->id;
        return CommentOfSuggestion::with('userId')
                                    ->where('suId', $id)
                                    ->orderBy('created_at','desc')
                                    ->paginate(5);
    }

    public function removeComment(Request $request)
    {
        if($request->userId !== Auth::user()->id){
            return CommentOfSuggestion::where('id',$request->id)->update([
                'content' => "removed by Administrator",
                'isRemoved' => 1,
                ]);
            }
            else{
            return CommentOfSuggestion::where('id',$request->id)->update([
                'content' => "removed by Author",
                'isRemoved' => 1,
            ]);
        }
    }
    
}
