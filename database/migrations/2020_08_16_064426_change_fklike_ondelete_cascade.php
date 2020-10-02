<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFklikeOndeleteCascade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('like_tweet', function (Blueprint $table) {
            $table->renameColumn('pk_tweet', 'pk_parent');
            
            $table->foreign('pk_parent')
                  ->references('tweet_id')
                  ->on('tweet_post')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('like_tweet', function (Blueprint $table) {
            $table->unsignedBigInteger('pk_tweet')->change();
            $table->unsignedBigInteger('pk_profile')->change();

            $table->foreign('pk_tweet')->references('tweet_id')->on('tweet_post');
            $table->foreign('pk_profile')->references('profile_id')->on('profile');
        });
    }
}
