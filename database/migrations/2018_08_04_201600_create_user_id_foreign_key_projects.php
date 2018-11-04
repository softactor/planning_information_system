<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserIdForeignKeyProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->change();
            $table->integer('wing_id')->unsigned()->change();
            $table->integer('pcdivision_id')->unsigned()->change();
            $table->integer('subsector_id')->unsigned()->change();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('wing_id')->references('id')->on('wings');
            $table->foreign('pcdivision_id')->references('id')->on('pcdivisions');
            $table->foreign('subsector_id')->references('id')->on('subsectors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            //
        });
    }
}
