<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concourse extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'price', 'writing_date', 'starting_date', 'formation_id', 'ending_date', 'status'];

    public function concourse_writer(){
        return $this->hasMany('App\Models\ConcourseWriter');
    }
    public function formation(){
        return $this->belongsTo('App\Models\Formation');
    }
}
