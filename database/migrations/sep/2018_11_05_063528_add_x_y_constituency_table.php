<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddXYConstituencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('constituency', function (Blueprint $table) {
            $table->string('longitude', 200)->nullable()->after('id')->comment('This will take care of project Location');
            $table->string('latitude', 200)->nullable()->after('id')->comment('This will take care of project Location');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('constituency', function (Blueprint $table) {
            //
        });
    }
}
