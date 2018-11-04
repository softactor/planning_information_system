<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUnionColumnToProjectlocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projectlocations', function (Blueprint $table) {
            $table->integer('union_id')->unsigned()->nullable()->after("area");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projectlocations', function (Blueprint $table) {
            //
        });
    }
}
