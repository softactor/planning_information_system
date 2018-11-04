<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatCommonconfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commonconfs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('commonconf_name',50)->comment('Name of the commonconf');
            $table->string('commonconf_type',25)->comment('Name of the common Type, Example Donor');
            $table->tinyInteger('is_deleted')->default(0)->comment('Deleted (Yes/No)');
            $table->integer('user_id')->comment('user id table users');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('commonconfs');
    }
}
