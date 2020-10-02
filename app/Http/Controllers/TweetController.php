<?php

namespace App\Http\Controllers;

use Auth;
use App\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TweetController extends Controller
{
    // TODO: REFACTOR AND DOCUMENTATION
    /**
     * Joins table DB for retrieve the reply on specific tweet. 
     * 
     * @param $id
     * @return Object
     */
    public function getAllReply($id) {
        return DB::table('comment')
                  ->join('tweet_post', 'comment.pk_tweet', '=', 'tweet_post.tweet_id')
                  ->join('profile', 'comment.pk_profile', '=', 'profile.profile_id')
                  ->join('users', 'comment.pk_user', '=', 'users.id')
                  ->select( 
                      'profile.*', 'comment.*', 
                      'users.name', 'tweet_post.tweet_id'
                  )
                  ->where('tweet_id', $id)
                  ->get();
    }

    /**
     * Joins table to get all information tweet
     * 
     * @param $id
     * @return Object
     */
    public function showTweet($id) {
        return DB::table('users')
                  ->join('profile', 'users.id', '=', 'profile.pk_user')
                  ->join('tweet_post', 'users.id', '=', 'tweet_post.pk_user')
                  ->select('profile.*', 'users.name', 'tweet_post.*')
                  ->where('tweet_id', $id)
                  ->get();
    }

    /**
     * Display the specific resource
     * 
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $tweet = $this->showTweet($id);
        $reply = $this->getAllReply($id);

        $resource = [
            'tweet' => $tweet[0],
            'reply' => $reply
        ];
        return view('tweet_post.show')->withResource($resource);
    }

    /**
     * Store a newly created resource in storage
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // validate
        $request->validate([ 'content' => 'string|required|max:255' ]);

        // create a new resource
        $tweet = new Tweet;

        $tweet->pk_user = $request->id_user;
        $tweet->content = $request->content;

        // save to storage
        $tweet->save();

        // return redirect
        return redirect()->route('home')->with('status', 'Posting successfully');
    }

    /**
     * Update the specific resource in storage
     * 
     * @param $id
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        // validate
        $request->validate(['content' => 'string|required|max:255']);

        // update a specific resource
        $tweetUpdate = Tweet::find($id);
        $tweetUpdate->content = $request->content;

        // save update to storage
        $tweetUpdate->save();

        // return redirect
        return redirect()->route('home')->with('status', 'Updated Successfully');
    }

    /**
     * Delete the specific resource in storage
     * 
     * @param $id
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        // find a specific resource
        $tweetDelete = Tweet::find($id);
        // delete
        $tweetDelete->delete();
        // return redirect
        return redirect()->route('home')->with('status','Delete Successfully');
    }
}
