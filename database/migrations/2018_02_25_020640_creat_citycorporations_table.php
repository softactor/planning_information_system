<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatCitycorporationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citycorporations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('div_id')->comment('division id table division');
            $table->string('citycorp_name',300)->comment('Name of the City Corporation');
            $table->string('citycorp_name_bn',300)->nullable()->comment('Name of City Corporation Bangla');
			$table->string('geo_code',100)->nullable()->comment('Geo Code of Area');
            $table->string('citycorp_x',300)->nullable()->comment('Lattitude');
            $table->string('citycorp_y',300)->nullable()->comment('Longitude');
            $table->tinyInteger('is_deleted')->default(0)->comment('Deleted (Yes/No)');
            $table->integer('user_id')->comment('user id table users');
            $table->foreign('div_id')->references('id')->on('admdivisions')->onDelete('cascade');
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
        Schema::dropIfExists('citycorporations');
    }
}
