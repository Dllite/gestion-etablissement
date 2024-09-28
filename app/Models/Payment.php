<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = ['amount_paid', 'libelle', 'user_id', 'payment_mode', 'tranche', 'contact', 'concourse_writer_id', 'status'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function concourse_writer(){
        return $this->belongsTo('App\Models\ConcourseWriter');
    }
}
