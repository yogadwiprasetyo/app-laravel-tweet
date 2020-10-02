<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tweet_post', function (Blueprint $table) {
            $table->dropForeign(['pk_comment']);
            $table->dropForeign(['pk_like']);
            $table->dropColumn(['pk_comment', 'pk_like']);
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
