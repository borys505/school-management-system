<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Vendor extends Model
{
    use LogsActivity;

    protected $fillable = [
                            'name',
                            'phone',
                            'alternate_phone',
                            'email',
                            'tax_id',
                            'contact_person',
                            'contact_person_phone',
                            'contact_person_email',
                            'address_line_1',
                            'address_line_2',
                            'city',
                            'state',
                            'zipcode',
                            'country',
                            'options'
                        ];
    protected $casts = ['options' => 'array'];
    protected $primaryKey = 'id';
    protected $table = 'vendors';
    protected static $logName = 'vendor';
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
    protected static $ignoreChangedAttributes = ['updated_at'];

    public function expenses()
    {
        return $this->belongsTo('App\Models\Finance\Transaction\Expense');
    }

    public function getOption(string $option)
    {
        return array_get($this->options, $option);
    }
    
    public function scopeFilterById($q, $id)
    {
        if (! $id) {
            return $q;
        }

        return $q->where('id', '=', $id);
    }
}
