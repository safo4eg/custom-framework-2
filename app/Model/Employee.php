<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;
use Model\Man;

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

    public function man() {
        return $this->belongsTo(Man::class);
    }

    public function findIdentity(int $id)
    {
        self::where('people_id', $id)->first();
    }

    public function getId(): int
    {
        return $this->man->id;
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