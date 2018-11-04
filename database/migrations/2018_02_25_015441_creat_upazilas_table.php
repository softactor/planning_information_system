<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatUpazilasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upazilas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('district_id')->comment('district id table districts');
            $table->string('upazila_name',300)->comment('Name of the Upazila');
            $table->string('upazila_name_bn',300)->nullable()->comment('Name of Upazila Bangla');
            $table->string('geo_code',6)->nullable()->comment('GEO code');
            $table->string('upz_x',300)->nullable()->comment('Lattitude');
            $table->string('upz_y',300)->nullable()->comment('Longitude');
            $table->tinyInteger('is_deleted')->default(0)->comment('Deleted (Yes/No)');
            $table->integer('user_id')->comment('user id table users');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
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
        Schema::dropIfExists('upazilas');
    }
}
