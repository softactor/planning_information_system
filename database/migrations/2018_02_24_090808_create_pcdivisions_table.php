<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePcdivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pcdivisions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pcdivision_name',100)->comment('Sector Division Name');
            $table->string('pcdivision_name_bn',100)->nullable()->comment('Ministry of Roads, Highway and Bridge');
            $table->string('pcdivision_short_name',10)->nullable()->comment('Short Name. Example: PID');
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
        Schema::dropIfExists('pcdivisions');
    }
}
