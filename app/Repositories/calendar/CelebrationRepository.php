<?php
namespace App\Repositories\Calendar;

use Carbon\Carbon;
use App\Models\Student\Student;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeTerm;
use Illuminate\Validation\ValidationException;

class CelebrationRepository
{
    protected $student;
    protected $employee;
    protected $employee_term;

    /**
     * Instantiate a new instance.
     *
     * @return void
     */
    public function __construct(
        Student $student,
        Employee $employee,
        EmployeeTerm $employee_term
    ) {
        $this->student = $student;
        $this->employee = $employee;
        $this->employee_term = $employee_term;
    }

    /**
     * Get birthdays
     *
     * @return Employee or Student
     */
    public function getBirthday($params = array())
    {
        $start_date = gv($params, 'start_date') ? : date('Y-m-d');
        $end_date = gv($params, 'end_date') ? : date('Y-m-d');

        if (dateDiff($end_date, $start_date) > 365) {
            throw ValidationException::withMessages(['message' => trans('calendar.max_selection_period_is_one_year')]);
        }

        $type = gv($params, 'type', 'student');

        if ($type == 'student') {
            $query = $this->student->with(['studentRecords','studentRecords.batch','studentRecords.batch.course','parent'])->whereHas('studentRecords', function ($q){
                $q->whereNull('date_of_exit')->filterBySession();
            });
        } else {
            $query = $this->employee->with(['employeeDesignations','employeeDesignations.designation','employeeDesignations.designation.employeeCategory'])->whereHas('employeeTerms', function ($q) use($start_date, $end_date) {
                $q->whereNull('date_of_leaving');
            });
        }

        if (date('Y',strtotime($start_date)) < date('Y',strtotime($end_date))) {
            $query->where(function($q) use($start_date, $end_date){
                $q->where(function($q1) use($start_date, $end_date) {
                    $q1->whereRaw('DAYOFYEAR(date_of_birth) >= ?', Carbon::parse($start_date)->dayOfYear)->whereRaw('DAYOFYEAR(date_of_birth) <= ?', Carbon::parse($start_date)->endOfYear()->dayOfYear);
                })->orWhere(function($q2) use($start_date, $end_date){
                    $q2->whereRaw('DAYOFYEAR(date_of_birth) >= ?', 1)->whereRaw('DAYOFYEAR(date_of_birth) <= ?', Carbon::parse($end_date)->dayOfYear);
                }); 
            }); 
        } else {
            $query->whereRaw('DAYOFYEAR(date_of_birth) >= ?', Carbon::parse($start_date)->dayOfYear)->whereRaw('DAYOFYEAR(date_of_birth) <= ?', Carbon::parse($end_date)->dayOfYear);
        }

        return $query->orderBy(\DB::raw('MONTH(date_of_birth)'),'asc')->orderBy(\DB::raw('DAYOFMONTH(date_of_birth)'),'asc');
    }

    /**
     * Paginate all birthdays using given params.
     *
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateBirthday($params)
    {
        $page_length = gv($params, 'page_length', config('config.page_length'));

        return $this->getBirthday($params)->paginate($page_length);
    }

    /**
     * Get all filtered data for printing
     *
     * @param array $params
     * @return Employee or Student
     */
    public function printBirthday($params)
    {
        return $this->getBirthday($params)->get();
    }

    /**
     * Get anniversaries
     *
     * @return Employee
     */
    public function getAnniversary($params = array())
    {
        $start_date = gv($params, 'start_date') ? : date('Y-m-d');
        $end_date = gv($params, 'end_date') ? : date('Y-m-d');

        if (dateDiff($end_date, $start_date) > 365) {
            throw ValidationException::withMessages(['message' => trans('calendar.max_selection_period_is_one_year')]);
        }

        $query = $this->employee->with(['employeeDesignations','employeeDesignations.designation','employeeDesignations.designation.employeeCategory'])->whereHas('employeeTerms', function ($q) use($start_date, $end_date) {
            $q->whereNull('date_of_leaving');
        });

        if (date('Y',strtotime($start_date)) < date('Y',strtotime($end_date))) {
            $query->where(function($q) use($start_date, $end_date){
                $q->where(function($q1) use($start_date, $end_date) {
                    $q1->whereRaw('DAYOFYEAR(date_of_anniversary) >= ?', Carbon::parse($start_date)->dayOfYear)->whereRaw('DAYOFYEAR(date_of_anniversary) <= ?', Carbon::parse($start_date)->endOfYear()->dayOfYear);
                })->orWhere(function($q2) use($start_date, $end_date){
                    $q2->whereRaw('DAYOFYEAR(date_of_anniversary) >= ?', 1)->whereRaw('DAYOFYEAR(date_of_anniversary) <= ?', Carbon::parse($end_date)->dayOfYear);
                }); 
            }); 
        } else {
            $query->whereRaw('DAYOFYEAR(date_of_anniversary) >= ?', Carbon::parse($start_date)->dayOfYear)->whereRaw('DAYOFYEAR(date_of_anniversary) <= ?', Carbon::parse($end_date)->dayOfYear);
        }

        return $query->orderBy(\DB::raw('MONTH(date_of_anniversary)'),'asc')->orderBy(\DB::raw('DAYOFMONTH(date_of_anniversary)'),'asc');
    }

    /**
     * Paginate all anniversaries using given params.
     *
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateAnniversary($params)
    {
        $page_length = gv($params, 'page_length', config('config.page_length'));

        return $this->getAnniversary($params)->paginate($page_length);
    }

    /**
     * Get all filtered data for printing
     *
     * @param array $params
     * @return Employee
     */
    public function printAnniversary($params)
    {
        return $this->getAnniversary($params)->get();
    }

    /**
     * Get work anniversaries
     *
     * @return Employee
     */
    public function getWorkAnniversary($params = array())
    {
        $start_date = gv($params, 'start_date') ? : date('Y-m-d');
        $end_date = gv($params, 'end_date') ? : date('Y-m-d');

        if (dateDiff($end_date, $start_date) > 365) {
            throw ValidationException::withMessages(['message' => trans('calendar.max_selection_period_is_one_year')]);
        }

        $query = $this->employee_term->with('employee','employee.employeeDesignations','employee.employeeDesignations.designation','employee.employeeDesignations.designation.employeeCategory')->whereNull('date_of_leaving');

        if (date('Y',strtotime($start_date)) < date('Y',strtotime($end_date))) {
            $query->where(function($q) use($start_date, $end_date){
                $q->where(function($q1) use($start_date, $end_date) {
                    $q1->whereRaw('DAYOFYEAR(date_of_joining) >= ?', Carbon::parse($start_date)->dayOfYear)->whereRaw('DAYOFYEAR(date_of_joining) <= ?', Carbon::parse($start_date)->endOfYear()->dayOfYear);
                })->orWhere(function($q2) use($start_date, $end_date){
                    $q2->whereRaw('DAYOFYEAR(date_of_joining) >= ?', 1)->whereRaw('DAYOFYEAR(date_of_joining) <= ?', Carbon::parse($end_date)->dayOfYear);
                }); 
            }); 
        } else {
            $query->whereRaw('DAYOFYEAR(date_of_joining) >= ?', Carbon::parse($start_date)->dayOfYear)->whereRaw('DAYOFYEAR(date_of_joining) <= ?', Carbon::parse($end_date)->dayOfYear);
        }

        return $query->orderBy(\DB::raw('MONTH(date_of_joining)'),'asc')->orderBy(\DB::raw('DAYOFMONTH(date_of_joining)'),'asc');
    }

    /**
     * Paginate all work anniversaries using given params.
     *
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateWorkAnniversary($params)
    {
        $page_length = gv($params, 'page_length', config('config.page_length'));

        return $this->getWorkAnniversary($params)->paginate($page_length);
    }

    /**
     * Get all filtered data for printing
     *
     * @param array $params
     * @return Employee
     */
    public function printWorkAnniversary($params)
    {
        return $this->getWorkAnniversary($params)->get();
    }
}
