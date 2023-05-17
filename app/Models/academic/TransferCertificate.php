<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class TransferCertificate extends Model
{
    use LogsActivity;

    protected $fillable = [
                            'studdent_record_id',
                            'options'
                        ];
    protected $casts = ['options' => 'array'];
    protected $primaryKey = 'id';
    protected $table = 'transfer_certificates';
    protected static $logName = 'transfer_certificate';
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
    protected static $ignoreChangedAttributes = ['updated_at'];
    
    public function studentRecord()
    {
        return $this->belongsTo('App\Models\Student\StudentRecord');
    }

    public function getOption(string $option)
    {
        return array_get($this->options, $option);
    }

    public function getCertificateNumberAttribute()
    {
        return $this->prefix.$this->number.$this->suffix;
    }

    public function scopeInfo($q)
    {
        return $q->with(['studentRecord','studentRecord.batch','studentRecord.batch.course','studentRecord.student','studentRecord.student.parent','studentRecord.student.religion','studentRecord.student.caste','studentRecord.admission','studentRecord.admission.batch','studentRecord.admission.batch.course']);
    }
    
    public function scopeFilterById($q, $id)
    {
        if (! $id) {
            return $q;
        }

        return $q->where('id', '=', $id);
    }

    public function scopeFilterByUuid($q, $uuid)
    {
        if (! $uuid) {
            return $q;
        }

        return $q->where('uuid', '=', $uuid);
    }

    public function scopeFilterBySession($q)
    {
        return $q->where('date_of_issue', '>=', getStartOfDate(config('config.default_academic_session.start_date')))->where('date_of_issue', '<=', getEndOfDate(config('config.default_academic_session.end_date')));
    }

    public function scopeDateOfIssueBetween($q, $dates)
    {
        if ((! $dates['start_date'] || ! $dates['end_date']) && $dates['start_date'] <= $dates['end_date']) {
            return $q;
        }

        return $q->where('date_of_issue', '>=', getStartOfDate($dates['start_date']))->where('date_of_issue', '<=', getEndOfDate($dates['end_date']));
    }
}
