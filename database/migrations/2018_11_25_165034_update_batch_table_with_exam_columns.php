<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBatchTableWithExamColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->integer('exam_grade_id')->unsigned()->nullable()->after('name');
            $table->foreign('exam_grade_id')->references('id')->on('exam_grades')->onDelete('set null');
            $table->integer('exam_observation_id')->unsigned()->nullable()->after('name');
            $table->foreign('exam_observation_id')->references('id')->on('exam_observations')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('batches', function(Blueprint $table)
        {
            $table->dropForeign('batches_exam_grade_id_foreign');
            $table->dropForeign('batches_exam_observation_id_foreign');
            $table->dropColumn('exam_grade_id');
            $table->dropColumn('exam_observation_id');
        });
    }
}
