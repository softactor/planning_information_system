<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSumTotalToProjectcostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projectcosts', function (Blueprint $table) {
           $table->double('rev_total', 15, 8)->default(0)->after("expotherscont_pr");
           $table->double('cap_total', 15, 8)->default(0)->after("expotherscont_pr");
           $table->double('conph_total', 15, 8)->default(0)->after("expotherscont_pr");
           $table->double('conpr_total', 15, 8)->default(0)->after("expotherscont_pr");
           $table->double('sum_grand_total', 15, 8)->default(0)->after("expotherscont_pr");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projectcosts', function (Blueprint $table) {
            //
        });
    }
}
