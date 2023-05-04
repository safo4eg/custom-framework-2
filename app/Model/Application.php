<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    public $timestamps = false;
    public $with = ['employee', 'patient'];
    protected $fillable = ['employee_id', 'patient_id', 'diagnostic', 'date_of_application', 'date_of_visit'];

    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_id', 'person_id');
    }

    public function patient() {
        return $this->belongsTo(Patient::class, 'patient_id', 'person_id');
    }

    public static function getPatientsIds(int $doctor_id): array
    {
        $doctor_applications = self::where('employee_id', $doctor_id)->get()->toArray();
        $patients_ids = [];
        foreach($doctor_applications as $application) {
            if(!in_array($application['patient_id'], $patients_ids)) {
                $patients_ids[] = $application['patient_id'];
            }
        }
        return $patients_ids;
    }
}