<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class StudentRecord extends Model
{
    use LogsActivity;

    protected $fillable = [
                            'roll_number',
                            'academic_session_id',
                            'student_id',
                            'admission_id',
                            'fee_allocation_id',
                            'batch_id',
                            'date_of_entry',
                            'entry_remarks',
                            'date_of_exit',
                            'exit_remarks',
                            'options'
                        ];
    protected $casts = ['options' => 'array'];
    protected $primaryKey = 'id';
    protected $table = 'student_records';
    protected static $logName = 'student_record';
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
    protected static $ignoreChangedAttributes = ['updated_at'];
    
    public function academicSession()
    {
        return $this->belongsTo('App\Models\Academic\AcademicSession');
    }

    public function student()
    {
        return $this->belongsTo('App\Models\Student\Student');
    }

    public function batch()
    {
        return $this->belongsTo('App\Models\Academic\Batch');
    }

    public function admission()
    {
        return $this->belongsTo('App\Models\Student\Admission');
    }

    public function feeAllocation()
    {
        return $this->belongsTo('App\Models\Finance\Fee\FeeAllocation');
    }

    public function studentFeeRecords()
    {
        return $this->hasMany('App\Models\Student\StudentFeeRecord');
    }

    public function transportRouteStudent()
    {
        return $this->hasOne('App\Models\Transport\TransportRouteStudent');
    }

    public function getOption(string $option)
    {
        return array_get($this->options, $option);
    }

    public function scopeFilterBySession($q, $session_id = null)
    {
        return $q->where('academic_session_id', '=', $session_id ? : config('config.default_academic_session.id'));
    }
    
    public function scopeFilterById($q, $id)
    {
        if (! $id) {
            return $q;
        }

        return $q->where('id', '=', $id);
    }
    
    public function scopeFilterByFirstName($q, $first_name, $s = 0)
    {
        if (! $first_name) {
            return $q;
        }

        return $q->whereHas('student', function ($q) use ($first_name, $s) {
            ($s) ? $q->where('first_name', '=', $first_name) : $q->where('first_name', 'like', '%'.$first_name.'%');
        });
    }
    
    public function scopeFilterByLastName($q, $last_name, $s = 0)
    {
        if (! $last_name) {
            return $q;
        }

        return $q->whereHas('student', function ($q) use ($last_name, $s) {
            ($s) ? $q->where('last_name', '=', $last_name) : $q->where('last_name', 'like', '%'.$last_name.'%');
        });
    }
    
    public function scopeFilterByFatherName($q, $father_name, $s = 0)
    {
        if (! $father_name) {
            return $q;
        }

        return $q->whereHas('student', function ($q) use ($father_name, $s) {
            ($s) ? $q->where('father_name', '=', $father_name) : $q->where('father_name', 'like', '%'.$father_name.'%');
        });
    }
    
    public function scopeFilterByMotherName($q, $mother_name, $s = 0)
    {
        if (! $mother_name) {
            return $q;
        }

        return $q->whereHas('student', function ($q) use ($mother_name, $s) {
            ($s) ? $q->where('mother_name', '=', $mother_name) : $q->where('mother_name', 'like', '%'.$mother_name.'%');
        });
    }
    
    public function scopeFilterByBatchesId($q, $batch_id)
    {
        if (! count($batch_id)) {
            return $q;
        }

        return $q->whereIn('batch_id', $batch_id);
    }
    
    public function scopeFilterByBatchId($q, $batch_id)
    {
        if (! $batch_id) {
            return $q;
        }

        return $q->where('batch_id', $batch_id);
    }
    
    public function scopeFilterByStudentId($q, $student_id)
    {
        if (! $student_id) {
            return $q;
        }

        return $q->where('student_id', $student_id);
    }
    
    public function scopeFilterByAdmissionId($q, $admission_id)
    {
        if (! $admission_id) {
            return $q;
        }

        return $q->where('admission_id', $admission_id);
    }
    
    public function scopeFilterByBloodGroupId($q, $blood_group_id)
    {
        if (! count($blood_group_id)) {
            return $q;
        }

        return $q->whereHas('student', function ($q) use ($blood_group_id) {
            $q->whereIn('blood_group_id', $blood_group_id);
        });
    }
    
    public function scopeFilterByReligionId($q, $religion_id)
    {
        if (! count($religion_id)) {
            return $q;
        }

        return $q->whereHas('student', function ($q) use ($religion_id) {
            $q->whereIn('religion_id', $religion_id);
        });
    }
    
    public function scopeFilterByCasteId($q, $caste_id)
    {
        if (! count($caste_id)) {
            return $q;
        }

        return $q->whereHas('student', function ($q) use ($caste_id) {
            $q->whereIn('caste_id', $caste_id);
        });
    }
    
    public function scopeFilterByCategoryId($q, $category_id)
    {
        if (! count($category_id)) {
            return $q;
        }

        return $q->whereHas('student', function ($q) use ($category_id) {
            $q->whereIn('category_id', $category_id);
        });
    }

    public function scopeDateOfBirthBetween($q, $dates)
    {
        if ((! $dates['start_date'] || ! $dates['end_date']) && $dates['start_date'] <= $dates['end_date']) {
            return $q;
        }

        return $q->whereHas('student', function ($q) use ($dates) {
            $q->where('date_of_birth', '>=', getStartOfDate($dates['start_date']))->where('date_of_birth', '<=', getEndOfDate($dates['end_date']));
        });
    }

    public function scopeDateOfAdmissionBetween($q, $dates)
    {
        if ((! $dates['start_date'] || ! $dates['end_date']) && $dates['start_date'] <= $dates['end_date']) {
            return $q;
        }

        return $q->whereHas('admission', function ($q) use ($dates) {
            $q->where('date_of_admission', '>=', getStartOfDate($dates['start_date']))->where('date_of_admission', '<=', getEndOfDate($dates['end_date']));
        });
    }

    public function scopeDateOfExitBetween($q, $dates)
    {
        if ((! $dates['start_date'] || ! $dates['end_date']) && $dates['start_date'] <= $dates['end_date']) {
            return $q;
        }

        return $q->where('date_of_exit', '>=', getStartOfDate($dates['start_date']))->where('date_of_exit', '<=', getEndOfDate($dates['end_date']));
    }
}
