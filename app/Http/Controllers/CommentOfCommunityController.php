<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\CommentOfCommunity;
use App\Community;

class CommentOfCommunityController extends Controller
{
    public function leaveComment(Request $request)
    {
        $commentData = $request->commentData;
        $communityData = $request->communityData;
        $currentCommunityId = $communityData['id'];
        $userId = Auth::user()->id;
        $comment['userId'] = $userId;
        $comment['coId'] = $currentCommunityId;
        $comment['content'] = $commentData;
        $commentToCommunity = CommentOfCommunity::create($comment); 
        $commentToCommunity->parentId = $commentToCommunity->id;
        $commentToCommunity->save();

        $currentCommunity = Community::where('id', $currentCommunityId)->first();
        $currentCommentCnt = json_decode($currentCommunity->comment_cnt);
        if($currentCommentCnt == null){
            $currentCommentCnt[] = $userId;
            $currentCommunity->comment_cnt = $currentCommentCnt;
            $currentCommunity->save();
            return response()->json([
                'commentToCommunity' => $commentToCommunity
            ], 201);
        }
        else{
            array_push($currentCommentCnt, $userId);
            $currentCommunity->comment_cnt = $currentCommentCnt;
            $currentCommunity->save();
            return response()->json([
                'commentToCommunity' => $commentToCommunity
            ], 201);
        }
    }

    public function getComment(Request $request)
    {
        $userId = Auth::user()->id;
        $id = $request->id;
        return CommentOfCommunity::with('userId')
                                    ->where('coId', $id)
                                    ->orderby('parentId', 'desc')
                                    ->orderby('seq')
                                    ->paginate(5);
    }

    public function removeComment(Request $request)
    {
        if($request->userId !== Auth::user()->id){
            return CommentOfCommunity::where('id',$request->id)->update([
                'content' => "removed by Administrator",
                'isRemoved' => 1,
                ]);
            }
            else{
            return CommentOfCommunity::where('id',$request->id)->update([
                'content' => "removed by Author",
                'isRemoved' => 1,
            ]);
        }
    }

    public function replyToComment(Request $request)
    {
        $parentComment = $request->parentComment;
        $childCommentContent = $request->childCommentContent;
        
        CommentOfCommunity::where([
            ['parentId', $parentComment['parentId']],
            ['seq', '>', $parentComment['seq'] ],
        ])->increment('seq', 1);
        
        $replyToCommentData = new CommentOfCommunity;
        
        $replyToCommentData->userId = Auth::user()->id;
        $replyToCommentData->coId = $parentComment['coId'];
        $replyToCommentData->content = $childCommentContent;
        $replyToCommentData->seq = $parentComment['seq'] + 1;
        $replyToCommentData->lvl = $parentComment['lvl'] + 1;
        $replyToCommentData->parentId = $parentComment['parentId'];
        $replyToCommentData->save();

        $currentCommunity = Community::where('id', $replyToCommentData->coId)->first();
        $currentCommentCnt = json_decode($currentCommunity->comment_cnt);
        array_push($currentCommentCnt, $replyToCommentData->userId);
        $currentCommunity->comment_cnt = $currentCommentCnt;
        $currentCommunity->save();

        return response()->json([
            'replyToCommentData' => $replyToCommentData
        ], 201);
    }

}
