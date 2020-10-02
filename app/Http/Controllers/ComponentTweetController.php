<?php

namespace App\Http\Controllers;

use App\User;
use App\Comment;
use Illuminate\Http\Request;

class ComponentTweetController extends Controller
{
    /**
     * Store a newly reply resource in storage
     * 
     * @param $id
     * @param Request $request
     * 
     * @param \Illuminate\Http\Response
     */
    public function storeReply(Request $request, $id) {
        // validate
        $request->validate([ 'content' => 'string|required|max:255' ]);

        // get profile_id from relationship User and Profile
        $profile = User::find($request->id)->profile;

        // create a new reply
        $reply = new Comment;
        $reply->pk_tweet = $id;
        $reply->pk_user = $request->id;
        $reply->pk_profile = $profile->profile_id;
        $reply->comment = $request->content;

        // saving
        $reply->save();

        return redirect()->route('tweet.show', ['id' => $id]);
    }

    /**
     * Update the specific resource in storage
     * 
     * @param $id
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function updateReply(Request $request, $id) {
        // validate
        $request->validate(['content' => 'string|required|max:255']);

        // update a specific resource
        $replyUpdate = Comment::find($id);
        $replyUpdate->comment = $request->content;

        // save update to storage
        $replyUpdate->save();

        // return redirect
        return redirect()->back()->with('status', 'Reply Edit Successfully');
    }

    /**
     * Delete the specific resource in storage
     * 
     * @param $id
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroyReply( $id) {
        // find a specific resource
        $replyDelete = Comment::find($id);
        // delete
        $replyDelete->delete();
        // return redirect
        return redirect()->back()->with('status', 'Reply Delete Successfully');
    }
}
