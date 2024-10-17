<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    private $follow;

    public function __construct(Follow $follow)
    {
        $this->follow = $follow;
    }

    # follow
    public function store($user_id)
    {
        $this->follow->follower_id = Auth::user()->id;
        // the Auth user is the follower. The Auth user is the one creating the action to follow a user
        $this->follow->following_id = $user_id;
        $this->follow->save();

        return redirect()->back();
    }

    # unfollow
    public function destroy($user_id)
    {
        $this->follow->where('follower_id', Auth::user()->id)
                ->where('following_id', $user_id)
                ->delete();

        return redirect()->back();
    }
}
