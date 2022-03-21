<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'country_code'
    ];

    public function City(){
        return $this->hasMany(City::class);
    }

    public function Employee(){
        return $this->hasMany(Employee::class);
    }
}
