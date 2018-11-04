<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('div_id')->comment('division id table admdivisions');
            $table->string('district_name',30)->comment('Name of the district');
            $table->string('district_bn',30)->nullable()->comment('Name of district Bangla');
            $table->string('geo_code',4)->nullable()->comment('GEO code');
            $table->string('ds_x',300)->nullable()->comment('Lattitude');
            $table->string('ds_y',300)->nullable()->comment('Longitude');
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
        Schema::dropIfExists('districts');
    }
}
