<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeoIdAndDeoDateIntoProjectVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_versions', function (Blueprint $table) {
            $table->integer('deo_id')->nullable()->after("user_id");
            $table->dateTime('deo_date')->nullable()->after("user_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_versions', function (Blueprint $table) {
            //
        });
    }
}
