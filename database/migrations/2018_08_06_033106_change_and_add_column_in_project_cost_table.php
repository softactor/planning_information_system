<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAndAddColumnInProjectCostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projectcosts', function (Blueprint $table) {
            $table->renameColumn('expgobcont', 'expgobcont_ph');
            $table->renameColumn('exppacont', 'exppacont_ph');
            $table->renameColumn('expofundcont', 'expofundcont_ph');
            $table->renameColumn('expotherscont', 'expotherscont_ph');
            $table->double('expgobcont_pr', 15, 8)->default(0);
            $table->double('exppacont_pr', 15, 8)->default(0);
            $table->double('expofundcont_pr', 15, 8)->default(0);
            $table->double('expotherscont_pr', 15, 8)->default(0);
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
