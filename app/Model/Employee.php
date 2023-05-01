<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;
use Model\Interfaces\DisplayedInterface;

class Employee extends Model implements IdentityInterface, DisplayedInterface
{
    public static $primary_fields = ['person', 'role', 'department'];
    private static $visible_fields = [
        'id' => 'id', 'name' => 'name', 'surname' => 'surname', 'patronymic' => 'patronymic',
        'date_of_birth' => 'date_of_birth', 'role' => 'role', 'specialization' => 'specialization',
        'department' => 'department', 'cabinet' => 'cabinet', 'status_id' => 'status_id'
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
    protected  $with = ['person', 'role', 'department'];

    public function department() {
        return $this->belongsTo(Department::class);
    }
    public function role() {
        return $this->belongsTo(Role::class);
    }
    public function person() {
        return $this->belongsTo(Person::class);
    }

    public static function getFieldsInFormattedArray(): array {
        $employees_list = self::all()->toArray();
        $formatted_employees_list = [];

        foreach($employees_list as $employee) {
            $current_employee = [];
            foreach($employee as $outer_key => $outer_value) {
                if(in_array($outer_key, self::$primary_fields)) {
                    if($outer_key !== 'person') {
                        $current_employee[$outer_key] = isset($outer_value['name'])? $outer_value['name']: null;
                        continue;
                    }
                    foreach($outer_value as $inner_key => $inner_value) {
                        if(in_array($inner_key, self::$visible_fields)) {
                            $current_employee[$inner_key] = $inner_value;
                        }
                    }
                    continue;
                }
//                if(isset($outer_value)) {
//                    if(in_array($outer_key, self::$primary_fields)) {
//                        foreach($outer_value as $inner_key => $inner_value) {
//                            $temp_key = ($outer_key !== 'person')? $outer_key: $outer_key."_".$inner_key;
//                            if(in_array($temp_key, self::$visible_fields)) {
//                                $current_employee[$temp_key] = $inner_value;
//                            }
//                        }
//                        continue;
//                    }
//                }
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
            $employee->password = md5($employee->password);
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