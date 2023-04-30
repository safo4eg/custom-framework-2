<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class Employee extends Model implements IdentityInterface
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
    protected $with = ['person'];

    public function person() {
        return $this->belongsTo(Person::class);
    }

    public function findIdentity(int $id)
    {
        return self::where('person_id', $id)->first();
    }

    public function getId(): int
    {
        return $this->person_id;
    }

    public function attemptIdentity(array $credentials)
    {
        return self::where(['login' => $credentials['login'],
            'password' => md5($credentials['password'])])->first();
    }

    protected static function booted()
    {
        static::created(function ($employee) {
            $employee->password = password_hash($employee->password, PASSWORD_DEFAULT);
            $employee->save();
        });
    }
}