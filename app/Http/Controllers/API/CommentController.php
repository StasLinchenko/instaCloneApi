<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CommentResource as CommentResource;
class CommentController extends BaseController
{
    public function store(Request $request) {
        $input = $request->all();
        $user_id = Auth::id();
        $input ['user_id'] = $user_id;
        $validator = Validator::make($input, [
            'desc'    => 'required|max:255',
            'post_id' => 'required',
            'user_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $comment = Comment::create($input);

        return $this->sendResponse(new CommentResource($comment),'comment created successfully');
    }

    public function delete(Comment $comment) {
        $comment->delete();
        return $this->sendResponse([],'comment deleted');
    }

    public function update (Request $request, Comment $comment) {

        $input = $request->all();

        $validator = Validator::make($input,[
            'desc' => 'required:255',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $comment->desc = $input['desc'];
        $comment->save();

        return $this->sendResponse(new CommentResource($comment), 'comment updated');
    }
}
