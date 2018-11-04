<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatAdmdivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admdivisions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dvname',30)->comment('Name of the division');
            $table->string('dvname_bn',30)->nullable()->comment('Name of the division Bangla');
            $table->string('geo_code',4)->nullable()->comment('GEO code');
            $table->string('dv_x',300)->comment('Lattitude');
            $table->string('dv_y',300)->comment('Longitude');
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
        Schema::dropIfExists('admdivisions');
    }
}
