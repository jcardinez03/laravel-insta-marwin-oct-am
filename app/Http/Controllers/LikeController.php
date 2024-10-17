<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    private $like;

    public function __construct(Like $like)
    {
        $this->like = $like;
    }

    # Like
    public function store($post_id)
    {
        $this->like->user_id        = Auth::user()->id; // Who liked the post
        $this->like->post_id        = $post_id; // which post was liked
        $this->like->save();

        return redirect()->back();
    }

    # Unlike
    public function destroy($post_id)
    {
        $this->like->where('user_id', Auth::user()->id)
                ->where('post_id', $post_id)
                ->delete();

        return redirect()->back();
    }
}
