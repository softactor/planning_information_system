<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('division_id')->unsigned();
            $table->integer('district_id')->unsigned();
            $table->integer('upz_id')->unsigned();
            $table->string('union_name', 200)->nullable();
            $table->string('union_name_bn',400)->nullable();
            $table->string('geo_code',6)->nullable()->comment('GEO code');
            $table->string('un_x',300)->nullable()->comment('Lattitude');
            $table->string('un_y',300)->nullable()->comment('Longitude');
            $table->integer('constituency')->nullable()->after("un_y");
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
        Schema::dropIfExists('unions');
    }
}
