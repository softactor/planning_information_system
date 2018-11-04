<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserIdForeignKeyProjectLocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projectlocations', function (Blueprint $table) {
            $table->integer('project_id')->unsigned()->change();
            $table->integer('district_id')->unsigned()->change();
            $table->integer('upz_id')->unsigned()->change();
            $table->integer('city_corp_id')->unsigned()->change();
            $table->integer('ward_id')->unsigned()->change();
            $table->integer('gisobject_id')->unsigned()->change();
            $table->integer('user_id')->unsigned()->change();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('district_id')->references('id')->on('districts');
            $table->foreign('upz_id')->references('id')->on('upazilas');
            $table->foreign('city_corp_id')->references('id')->on('citycorporations');
            $table->foreign('ward_id')->references('id')->on('wards');
            $table->foreign('gisobject_id')->references('id')->on('gisobjects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projectlocations', function (Blueprint $table) {
            //
        });
    }
}
