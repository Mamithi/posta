<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistorysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('box');
            $table->string('code');
            $table->string('town');
            $table->string('status');
            $table->string('person_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('historyss');
    }
}
