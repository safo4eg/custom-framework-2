<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    public $timestamps = false;
    protected $table = 'people';
    protected $fillable = ['name', 'surname', 'patronymic', 'date_of_birth'];

    public function employee() {
        return $this->hasOne(Employee::class);
    }

    public function patient() {
        return $this->hasOne(Patient::class);
    }
}