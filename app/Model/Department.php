<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';

    public function employee() {
        return $this->hasMany(Employee::class);
    }
}