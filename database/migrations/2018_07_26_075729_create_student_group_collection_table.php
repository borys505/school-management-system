<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentGroupCollectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_group_collection', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('student_id')->unsigned()->nullable();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->integer('student_group_id')->unsigned()->nullable();
            $table->foreign('student_group_id')->references('id')->on('student_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_group_collection', function(Blueprint $table)
        {
            $table->dropForeign('student_group_collection_student_id_foreign');
            $table->dropForeign('student_group_collection_student_group_id_foreign');
        });

        Schema::dropIfExists('student_group_collection');
    }
}
