<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThreeNewColumnInProjectDetailsTableUp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_details', function (Blueprint $table) {
            $table->text('objectives')->nullable()->change();
            $table->text('backgrounds')->nullable()->change();
            $table->text('activities')->nullable()->change();
            $table->text('objectives_bng')->nullable()->after("activities");
            $table->text('backgrounds_bng')->nullable()->after("activities");
            $table->text('activities_bng')->nullable()->after("activities");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_details', function (Blueprint $table) {
            //
        });
    }
}
