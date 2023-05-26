<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Caste extends Model
{
    public $table = 'caste';
    protected $fillable = [
        'name','status'
    ];
}
