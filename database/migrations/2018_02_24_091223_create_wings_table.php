<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pcdivision_id')->comment('sector division id table pcdivisions id');
            $table->string('wing_name',100)->comment('Name of the wing');
            $table->string('wing_name_bn',100)->nullable()->comment('Name of the wing in bangla');
            $table->string('wing_short_name',10)->nullable()->comment('Short Name. Example: PID');
            $table->tinyInteger('is_deleted')->default(0)->comment('Deleted (Yes/No)');
            $table->integer('user_id')->comment('user id table users');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pcdivision_id')->references('id')->on('pcdivisions')->onDelete('cascade');
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
        Schema::dropIfExists('wings');
    }
}
