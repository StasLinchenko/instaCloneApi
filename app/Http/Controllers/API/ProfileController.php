<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\Post as PostResource;
use App\Http\Resources\UserResource as UserResource;
Use App\Models\User;
Use App\Models\Post;

class ProfileController extends BaseController
{
    public function index(User $user) {

        $post= User::with('posts')->withCount('posts')->where('id', '=', $user->id)->get();
        return $this->sendResponse(PostResource::collection($post),'user profile');
    }

    public function update(Request $request, User $user) {

        $input = $request->all();
        $validator = Validator::make($input,[
            'name' => 'max:30|required',
        ]);

        if($validator->fails()) {
            return $this->sendError('validator error', $validator->errors());
        }

        $user->name =$input['name'];
        $user->save();

        return $this->sendResponse(new UserResource($user),'user updated!');
    }
}
