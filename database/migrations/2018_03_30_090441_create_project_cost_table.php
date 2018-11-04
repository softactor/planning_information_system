<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectCostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projectcosts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->comment('project_id');
            $table->date('implstartdate')->comment('fa_country');
            $table->date('implenddate')->comment('fa_donor');
            $table->double('expgobrev', 15, 8)->default(0)->comment('expgobrev');
            $table->double('expparev', 15, 8)->default(0)->comment('expparev');
            $table->double('expofundrev', 15, 8)->default(0)->comment('expofundrev');
            $table->double('expothersrev', 15, 8)->default(0)->comment('expothersrev');
            $table->double('expgobcap', 15, 8)->default(0)->comment('expgobcap');
            $table->double('exppacap', 15, 8)->default(0)->comment('exppacap');
            $table->double('expofundcap', 15, 8)->default(0)->comment('expofundcap');
            $table->double('expotherscap', 15, 8)->default(0)->comment('expotherscap');
            $table->double('expgobcont', 15, 8)->default(0)->comment('expgobcont');
            $table->double('exppacont', 15, 8)->default(0)->comment('exppacont');
            $table->double('expofundcont', 15, 8)->default(0)->comment('expofundcont');
            $table->double('expotherscont', 15, 8)->default(0)->comment('expotherscont');
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
        Schema::dropIfExists('projectcosts');
    }
}
