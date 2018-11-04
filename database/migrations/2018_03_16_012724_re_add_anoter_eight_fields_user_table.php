<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReAddAnoterEightFieldsUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name',150)->nullable()->comment('First Name Of The User');
            $table->string('last_name',150)->nullable()->comment('Last Name Of The User');
            $table->integer('pcdivision_id')->nullable()->comment('pcdivision id table pcdivisions');
            $table->integer('wing_id')->nullable()->comment('wing id table wings');
            $table->string('designation',100)->nullable()->comment('Designation');
            $table->string('mobile',30)->nullable()->comment('mobile_number');
            $table->tinyInteger('status')->default(1)->comment('Deleted (Yes/No)');
            $table->tinyInteger('user_type')->default(3)->comment('Deleted (Yes/No)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
