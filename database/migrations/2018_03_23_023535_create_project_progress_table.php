<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_progress', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->comment('project_id');
            $table->integer('pversion_id')->comment('pversion_id');
            $table->string('progresstype',300)->comment('progresstype');
            $table->date('progressdate')->comment('progressdate');
            $table->string('progressdecision')->nullable()->comment('progressdecision');
            $table->tinyInteger('proapp')->default(0)->comment('Project approval (Y/N)');
            $table->date('proapp_date')->nullable()->comment('Approval Date');
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
        Schema::dropIfExists('project_progress');
    }
}
