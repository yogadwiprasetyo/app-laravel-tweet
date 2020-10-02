<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFkLike extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tweet_post', function (Blueprint $table) {
            $table->dropForeign(['pk_like']);

            $table->foreign('pk_like')->references('like_id')->on('like_tweet');
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
