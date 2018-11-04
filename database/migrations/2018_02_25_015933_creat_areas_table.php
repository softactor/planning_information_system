<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('upz_id')->comment('upazial id table upazilas');
            $table->string('area_name',30)->comment('Name of the Area');
            $table->string('area_name_bn',30)->nullable()->comment('Name of Area Bangla');
            $table->string('geo_code',100)->nullable()->comment('Geo Code of Area');
            $table->string('area_x',300)->comment('Lattitude');
            $table->string('area_y',300)->comment('Longitude');
            $table->tinyInteger('is_deleted')->default(0)->comment('Deleted (Yes/No)');
            $table->integer('user_id')->comment('user id table users');
            $table->foreign('upz_id')->references('id')->on('upazilas')->onDelete('cascade');
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
        Schema::dropIfExists('areas');
    }
}
