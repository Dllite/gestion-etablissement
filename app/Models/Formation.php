<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;
    protected $fillable = ["name","price","installment_date_one","installment_date_two","installment_date_three","installment_one","installment_two","installment_three","status","user_id"];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function student(){
        return $this->hasMany('App\Models\Student');
    }
    public function concourse(){
        return $this->hasMany('App\Models\Concourse');
    }
}
