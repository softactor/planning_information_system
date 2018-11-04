<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProjectForeignAssistanceAdd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_fas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->comment('project_id');
            $table->integer('fa_country')->comment('fa_country');
            $table->integer('fa_donor')->comment('fa_donor');
            $table->integer('fa_mof')->comment('fa_mof');
            $table->float('fa_amount')->comment('fa_amount');
            $table->tinyInteger('is_deleted')->default(0)->comment('Deleted (Yes/No)');
            $table->integer('user_id')->comment('user id table users');
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
        Schema::dropIfExists('project_fas');
    }
}
