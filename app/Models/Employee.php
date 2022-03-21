<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'firstname',
        'lastname',
        'middle_name',
        'address',
        'country_id',
        'city_id',
        'department_id',
        'zip_code',
        'birthdate',
        'date_hired',
    ];

    public function Country(){
       return $this->belongsTo(Country::class);
    }

    public function City(){
        return $this->belongsTo(City::class);
    }

    public function Department(){
        return $this->belongsTo(Department::class);
    }

}
