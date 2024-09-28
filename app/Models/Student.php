<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'location', 'status', 'user_id', 'formation_id', 'image', 'card'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function formation(){
        return $this->belongsTo('App\Models\Formation');
    }
    public function payment(){
        return $this->hasMany('App\Models\Payment');
    }
    public function getImageAttribute()
    {
        return env('APP_URL') ."/storage/student/". $this->attributes['image'];
    }
}
