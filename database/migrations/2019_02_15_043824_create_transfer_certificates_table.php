<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_certificates', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('student_record_id')->unsigned()->nullable();
            $table->foreign('student_record_id')->references('id')->on('student_records')->onDelete('cascade');
            $table->string('prefix')->nullable();
            $table->integer('number')->default(0);
            $table->string('suffix')->nullable();
            $table->string('course_in_words')->nullable();
            $table->text('last_exam_with_result')->nullable();
            $table->text('is_last_exam_failed')->nullable();
            $table->text('qualified_for_promotion')->nullable();
            $table->text('subject_studied')->nullable();
            $table->text('third_language')->nullable();
            $table->text('fee_paid_upto')->nullable();
            $table->text('working_days')->nullable();
            $table->text('present_days')->nullable();
            $table->text('cocurricular_activities')->nullable();
            $table->text('general_conduct')->nullable();
            $table->text('date_of_application')->nullable();
            $table->text('date_of_issue')->nullable();
            $table->text('reason')->nullable();
            $table->text('admission_in_institute')->nullable();
            $table->text('remarks')->nullable();
            $table->text('options')->nullable();
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
        Schema::table('transfer_certificates', function(Blueprint $table)
        {
            $table->dropForeign('transfer_certificates_student_record_id_foreign');
        });

        Schema::dropIfExists('transfer_certificates');
    }
}
