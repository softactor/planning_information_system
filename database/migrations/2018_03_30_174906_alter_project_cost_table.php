<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProjectCostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projectcosts', function (Blueprint $table) {
            $table->double('gob_gt', 15, 8)->default(0)->after('expotherscont');
            $table->double('pa_gt', 15, 8)->default(0)->after('expotherscont');
            $table->double('own_gt', 15, 8)->default(0)->after('expotherscont');
            $table->double('oth_gt', 15, 8)->default(0)->after('expotherscont');
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
