<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFkprofileTweetPost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tweet_post', function (Blueprint $table) {
            $table->dropForeign(['pk_profile']);

            $table->renameColumn('pk_profile', 'pk_user');
            $table->foreign('pk_user')->references('id')->on('users')->onDelete('cascade');
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
