<?php

namespace App;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','activation_token'
    ];

    public function student()
    {
        return $this->hasOne('App\Models\Student\Student');
    }

    public function parent()
    {
        return $this->hasOne('App\Models\Student\StudentParent');
    }

    public function employee()
    {
        return $this->hasOne('App\Models\Employee\Employee');
    }

    public function userPreference()
    {
        return $this->hasOne('App\UserPreference');
    }

    public function getProfile()
    {
        if ($this->hasRole(config('system.default_role.student'))) {
            $profile = $this->Student;
        } else {
            $profile = $this->Employee;
        }

        return $profile;
    }

    public function getNameAttribute()
    {
        $profile = $this->getProfile();

        return $profile->first_name.' '.$profile->middle_name.' '.$profile->last_name;
    }

    public function getNameWithEmailAttribute()
    {
        $profile = $this->getProfile();

        return $profile->first_name.' '.$profile->middle_name.' '.$profile->last_name.' ('.$this->email.')';
    }

    public function scopeFilterByEmail($q, $email = null, $s = 0)
    {
        if (! $email) {
            return $q;
        }

        return ($s) ? $q->where('email', '=', $email) : $q->where('email', 'like', '%'.$email.'%');
    }

    public function scopeFilterByUsername($q, $username = null, $s = 0)
    {
        if (! $username) {
            return $q;
        }
        
        return ($s) ? $q->where('username', '=', $username) : $q->where('username', 'like', '%'.$username.'%');
    }

    public function scopeFilterByRoleId($q, $role_id = null)
    {
        if (! $role_id) {
            return $q;
        }

        return $q->whereHas('roles', function ($q) use ($role_id) {
            $q->where('role_id', '=', $role_id);
        });
    }

    public function scopeFilterByStatus($q, $status = null)
    {
        if (! $status) {
            return $q;
        }

        return $q->where('status', '=', $status);
    }

    public function scopeCreatedAtDateBetween($q, $dates)
    {
        if ((! $dates['start_date'] || ! $dates['end_date']) && $dates['start_date'] <= $dates['end_date']) {
            return $q;
        }

        return $q->where('created_at', '>=', getStartOfDate($dates['start_date']))->where('created_at', '<=', getEndOfDate($dates['end_date']));
    }
}
