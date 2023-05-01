<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    public function employee() {
        return $this->hasMany(Employee::class);
    }
}