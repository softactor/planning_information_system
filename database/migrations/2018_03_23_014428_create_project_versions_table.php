<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_versions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->comment('project_id');
            $table->integer('project_type_id')->comment('project_type');
            $table->string('projectcode',300)->comment('projectcode');
            $table->tinyInteger('pstatus')->default(1)->comment('1=new; 2;= Revised');
            $table->integer('rev_number')->comment('rev_number');
            $table->date('statusdate')->comment('statusdate');
            $table->tinyInteger('qreview')->default(0)->comment('qreview');
            $table->date('qrview_date')->nullable()->comment('qrview_date');
            $table->tinyInteger('is_deleted')->default(0)->comment('Deleted (Yes/No)');
            $table->integer('user_id')->comment('user id table users');
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
        Schema::dropIfExists('project_progress');
    }
}
