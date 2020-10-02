<?php

namespace App\Http\Controllers;

use App\Tweet;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    // TODO: REFACTOR AND DOCUMENTATION

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        // Jika user sudah login
        // set profile auth.
        if (Auth::check()) {
            $profile = User::find(Auth::id())->profile;
        } else {
            // set profile guest
            $profile = true;
        }

        // jika belum punya profile redirect to create profile
        if (!$profile) {
            return redirect()->route('profile.create');
        }

        // get all tweet
        $tweet = $this->allTweet();
        
        $resource = [
            'profile' => $profile, 
            'tweet' => $tweet,
        ];
        return view('home')->withResource($resource);
    }

    /**
     * Joins table to get all information tweet
     * 
     * @return Object
     */
    public function allTweet() {
        return DB::table('users')
                  ->join('profile', 'users.id', '=', 'profile.pk_user')
                  ->join('tweet_post', 'users.id', '=', 'tweet_post.pk_user')
                  ->select(
                      'profile.p_username', 'profile.p_image', 'profile.pk_user',
                      'profile.profile_id', 'users.name', 'tweet_post.*'
                    )
                  ->orderBy('tweet_post.created_at', 'desc')
                  ->get();
    }
}
