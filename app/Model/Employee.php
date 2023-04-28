<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $timestamp = false;
    protected $fillable = [
        'login',
        'password',
        'people_id',
        'role_id',
        'specialization',
        'department_id',
        'cabinet'
    ];

    protected static function booted()
    {
        static::created(function ($employee) {
            $employee->password = password_hash($employee->password, PASSWORD_DEFAULT);
            $employee->save();
        });
    }
}