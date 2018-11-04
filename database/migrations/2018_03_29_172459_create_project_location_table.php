<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projectlocations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->comment('project_id');
            $table->integer('district_id')->nullable()->comment('district_id');
            $table->integer('upz_id')->nullable()->comment('upz_id');
            $table->string('area',300)->nullable()->comment('area');
            $table->string('roadno',300)->nullable()->comment('roadno');
            $table->string('loc_x',300)->nullable()->comment('loc_x');
            $table->string('loc_y',300)->nullable()->comment('loc_y');
            $table->integer('city_corp_id')->nullable()->comment('city_corp_id');
            $table->integer('ward_id')->nullable()->comment('ward_id');
            $table->integer('gisobject_id')->nullable()->comment('gisobject_id');
            $table->double('estmcost', 15, 8)->default(0)->comment('estmcost');
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
        Schema::dropIfExists('projectlocations');
    }
}
