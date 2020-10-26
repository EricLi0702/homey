<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\CommentOfSuggestion;

class CommentOfSuggestionController extends Controller
{
    public function leaveComment(Request $request)
    {
        $commentData = $request->commentData;
        $suggestionData = $request->suggestionData;
        $userId = Auth::user()->id;
        $comment['userId'] = $userId;
        $comment['suId'] = $suggestionData['id'];
        $comment['content'] = $commentData;

        $commentToSuggest = CommentOfSuggestion::create($comment); 
        
        return response()->json([
            'commentToSuggest' => $commentToSuggest
            // 'commentToSuggest' => $commentToSuggest
        ], 201);
    }
}
