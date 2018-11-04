<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeMinistryColumnBnCollation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ministries', function (Blueprint $table) {
            $table->string('ministry_name_bn',100)->collation('utf8_unicode_ci')->change();
            $table->string('ministry_short_name',10)->collation('utf8_unicode_ci')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ministries', function (Blueprint $table) {
            //
        });
    }
}
