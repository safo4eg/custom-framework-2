<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Model\Interfaces\DisplayedInterface;

class Patient extends Model
{
    public $timestamps = false;
    protected $with = ['person'];
    private static $visible_fields = [
        'id' => 'id', 'name' => 'name', 'surname' => 'surname', 'patronymic' => 'patronymic',
        'date_of_birth' => 'date_of_birth', 'status_id' => 'status_id'
    ];

    public static function getFieldsInFormattedArray(): array {
        $patients_list = self::all()->toArray();
        $formatted_patients_list = [];

        foreach($patients_list as $patient) {
            $current_patient = [];
            foreach($patient as $outer_key => $outer_value) {
                if($outer_key === 'person') {
                    foreach($outer_value as $inner_key => $inner_value) {
                        if(in_array($inner_key, self::$visible_fields)) {
                            $current_patient[$inner_key] = $inner_value;
                        }
                    }
                    continue;
                }
                if(in_array($outer_key, self::$visible_fields)) {
                    $current_patient[$outer_key] = $outer_value;
                }
            }
            $formatted_patients_list[] = array_merge(self::$visible_fields, $current_patient);
        }
        return $formatted_patients_list;
    }

    public function person() {
        return $this->belongsTo(Person::class);
    }
}