<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('FirstName'); 
            $table->string('LastName'); 
            $table->string('Description');
            $table->string('Reference'); 
            $table->string('Email'); 
            $table->string('Phone');  
            $table->string('Type'); 
            $table->string('Amount'); 
            $table->string('PersonId'); 
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transactions');
    }
}
