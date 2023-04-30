<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    public $timestamps = false;

    public function person() {
        return $this->belongsTo(Person::class);
    }
}