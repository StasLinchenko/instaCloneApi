<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Post as PostResource;

use Illuminate\Support\Facades\Auth;

class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('comments')->get();
        return $this->sendResponse(postResource::collection($posts),'posts fetched');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $user_id = Auth::id();
        $input ['user_id'] = $user_id;
        $validator = Validator::make($input, [
            'desc' => 'max:255',
            'img'  => 'image:jpg,jpeg,png,svg|required',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $post = Post::create($input);

        return $this->sendResponse(new PostResource($post),'post created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::where('id', $id)->with("comments")->get();
        if(is_null($post)) {

            return $this->sendError('post does not exist!');

        }

        return $this->sendResponse(new postResource($post),'Post fetched!');
    }

    public function update(Request $request, Post $post)
    {
        $input = $request->all();
        $validator = Validator::make ($input,[
            'desc' => 'max:255|required',
        ]);

        if($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors());
        }
        $post->desc = $input['desc'];
        $post->save();

        return $this->sendResponse(new PostResource($post), 'post updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return $this->sendResponse([],'post deleted!');
    }
}
