<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetFkTweetPost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tweet_post', function (Blueprint $table) {
            $table->unsignedBigInteger('pk_profile')->change();
            $table->unsignedBigInteger('pk_comment')->change();
            $table->unsignedBigInteger('pk_like')->change();

            $table->foreign('pk_profile')->references('profile_id')->on('profile');
            $table->foreign('pk_comment')->references('comment_id')->on('comment');
            $table->foreign('pk_like')->references('like_id')->on('like');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tweet_post', function (Blueprint $table) {
            //
        });
    }
}
