<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projectagencies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->comment('project_id');
            $table->integer('ministry_id')->comment('ministry_id');
            $table->integer('agency_id')->comment('agency_id');
            $table->tinyInteger('lead_agency')->default(0)->comment('Deleted (Yes/No)');
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
        Schema::dropIfExists('projectagencies');
    }
}
