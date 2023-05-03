<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    public $timestamps = false;
    public $with = ['employee', 'patient'];
    protected $fillable = ['employee_id', 'patient_id', 'diagnostic', 'date_of_application', 'date_of_visit'];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function patient() {
        return $this->belongsTo(Patient::class);
    }
}