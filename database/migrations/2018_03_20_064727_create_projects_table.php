<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->date('project_entry_date')->comment('project_entry_date');
            $table->string('project_app_code',15)->comment('project_app_code');
            $table->string('project_name_eng',200)->comment('project_name_eng');
            $table->string('project_name_bng',200)->comment('project_name_bng');
            $table->string('project_short_name',100)->comment('project_short_name');
            $table->integer('pcdivision_id')->comment('pcdivision_id');
            $table->integer('wing_id')->comment('pcdivision_id');
            $table->integer('subsector_id')->comment('pcdivision_id');
            $table->string('search_keyword',200)->comment('search_keyword');
            $table->tinyInteger('protemp')->default(0)->comment('Deleted (Yes/No)');
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
        Schema::dropIfExists('projects');
    }
}
