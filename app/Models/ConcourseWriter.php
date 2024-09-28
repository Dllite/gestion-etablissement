<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConcourseWriter extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'matricule',
        'anciennete',
        'address',
        'contact_number',
        'type',
        'libelle',
        'classe_id',
        'payment_mode',
        'status',
        'user_id',
        'student_status',
        'payment_status'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function classe(){
        return $this->belongsTo('App\Models\Classe');
    }
    public function payment(){
        return $this->hasMany('App\Models\Payment');
    }
}
