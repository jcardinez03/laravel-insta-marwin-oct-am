<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    private $post;
    private $user;

    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $home_posts         = $this->getHomePosts();
        $suggested_users    = $this->getSuggestedUsers();
        return view('users.home')->with('home_posts', $home_posts)
                    ->with('suggested_users', $suggested_users);

    }

    # get the posts of the users that the Auth user is following
    public function getHomePosts()
    {
        $all_posts = $this->post->latest()->get();
        $home_posts = []; // in case the $home_posts is empty, it will not return NULL but empty instead

        foreach($all_posts as $post) {
            if($post->user->isFollowed() || $post->user->id === Auth::user()->id){
                $home_posts[] = $post;
            }
        }

        return $home_posts;
    }

    # to get the users that tthe Auth user is not folowing
    private function getSuggestedUsers()
    {
        $all_users = $this->user->all()->except(Auth::user()->id);
        $suggested_users = [];

        foreach($all_users as $user){
            if(!$user->isFollowed()){
                $suggested_users[] = $user;
            }
        }

        return array_slice($suggested_users, 0, 3);
        // array_slice(x,y,z)
        // x - array
        // y - offset/starting index
        // z - length
    }

    public function search(Request $request)
    {
        $users = $this->user->where('name', 'like', '%' . $request->search . '%')->get();

        return view('users.search')->with('users', $users)->with('search', $request->search);
    }
}
