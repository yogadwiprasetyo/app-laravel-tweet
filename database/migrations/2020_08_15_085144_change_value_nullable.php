<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeValueNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tweet_post', function (Blueprint $table) {
            $table->unsignedBigInteger('pk_comment')->nullable()->change();
            $table->unsignedBigInteger('pk_like')->nullable()->change();
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
