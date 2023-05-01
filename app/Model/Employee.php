<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;
use Model\Interfaces\DisplayedInterface;

class Employee extends Model implements IdentityInterface, DisplayedInterface
{
    private static $visible_fields = [
        'id' => 'id', 'name' => 'name', 'surname' => 'surname', 'patronymic' => 'patronymic',
        'date_of_birth' => 'date_of_birth', 'role_id' => 'role_id', 'specialization' => 'specialization',
        'department_id' => 'department_id', 'cabinet' => 'cabinet', 'status_id' => 'status_id'
    ];

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

    public static function getFieldsInFormattedArray(): array {
        $employees_list = self::all()->toArray();
        $formatted_employees_list = [];

        foreach($employees_list as $employee) {
            $current_employee = [];
            foreach($employee as $outer_key => $outer_value) {
                if($outer_key === 'person') {
                    foreach($outer_value as $inner_key => $inner_value) {
                        if(in_array($inner_key, self::$visible_fields)) {
                            $current_employee[$inner_key] = $inner_value;
                        }
                    }
                    continue;
                }
                if(in_array($outer_key, self::$visible_fields)) {
                    $current_employee[$outer_key] = $outer_value;
                }
            }
            $formatted_employees_list[] = array_merge(self::$visible_fields, $current_employee);
        }
        return $formatted_employees_list;
    }

    protected static function booted()
    {
        static::created(function ($employee) {
            $employee->password = password_hash($employee->password, PASSWORD_DEFAULT);
            $employee->save();
        });
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
}