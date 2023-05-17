<?php
namespace App\Repositories\Student;

use App\Models\Student\StudentRecord;
use Illuminate\Validation\ValidationException;
use App\Repositories\Configuration\Academic\CourseGroupRepository;

class TerminationRepository
{
    protected $student_record;
    protected $course_group;

    /**
     * Instantiate a new instance.
     *
     * @return void
     */
    public function __construct(
        StudentRecord $student_record,
        CourseGroupRepository $course_group
    ) {
        $this->student_record = $student_record;
        $this->course_group = $course_group;
    }

    /**
     * Get terminated student's filtered data
     *
     * @param array $params
     * @return StudentRecord
     */
    public function getData($params)
    {
        $sort_by        = gv($params, 'sort_by', 'date_of_exit');
        $order          = gv($params, 'order', 'desc');
        $batch_id       = gv($params, 'batch_id');
        $first_name     = gv($params, 'first_name');
        $last_name      = gv($params, 'last_name');
        $father_name    = gv($params, 'father_name');
        $mother_name    = gv($params, 'mother_name');

        $date_of_exit_start_date = gv($params, 'date_of_exit_start_date');
        $date_of_exit_end_date   = gv($params, 'date_of_exit_end_date');

        $batch_id = is_array($batch_id) ? $batch_id : ($batch_id ? explode(',', $batch_id) : []);

        $query = $this->student_record->with('student', 'student.parent', 'admission', 'batch', 'batch.course')->filterBySession()->whereNotNull('date_of_exit')->filterByBatchesId($batch_id)->whereHas('student', function ($q) use ($first_name, $last_name, $father_name, $mother_name) {
            $q->filterByFirstName($first_name)->filterByLastName($last_name);

            if ($father_name || $mother_name) {
                $q->whereHas('parent', function ($q1) use ($father_name, $mother_name) {
                    $q1->filterByFatherName($father_name)->filterByMotherName($mother_name);
                });
            }
        })->dateOfExitBetween([
                'start_date' => $date_of_exit_start_date,
                'end_date' => $date_of_exit_end_date
            ]);

        return $query->orderBy($sort_by, $order);
    }

    /**
     * Paginate terminated student records using given params.
     *
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($params)
    {
        $page_length = gv($params, 'page_length', config('config.page_length'));

        return $this->getData($params)->paginate($page_length);
    }

    /**
     * Get terminated student filtered data for printing
     *
     * @param array $params
     * @return StudentRecord
     */
    public function print($params)
    {
        return $this->getData($params)->get();
    }

    /**
     * Get student record filters.
     *
     * @return Array
     */
    public function getFilters()
    {
        $batches = $this->course_group->getBatchOption();

        return compact('batches');
    }

    /**
     * Terminate a student.
     *
     * @param integer $student_fee_record_id
     */
    public function terminate(StudentRecord $student_record, $params)
    {
        if ($student_record->date_of_exit) {
            throw ValidationException::withMessages(['message' => trans('general.invalid_action')]);
        }

        $date_of_termination = gv($params, 'date_of_termination');
        $termination_remarks = gv($params, 'termination_remarks');

        if ($student_record->date_of_entry >= $date_of_termination) {
            throw ValidationException::withMessages(['message' => trans('student.date_of_termination_less_than_date_of_admission')]);
        }

        if ($student_record->Student->StudentRecords->where('date_of_entry', '>', $student_record->date_of_entry)->where('id', '!=', $student_record->id)->count()) {
            throw ValidationException::withMessages(['message' => trans('student.no_termination_allowed_in_intermediate_records')]);
        }

        $student_record->date_of_exit = $date_of_termination;
        $student_record->exit_remarks = $termination_remarks;
        $student_record->save();
    }
}
