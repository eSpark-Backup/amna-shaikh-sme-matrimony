<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkingWith extends Model
{
	public $table = 'working_with';
    protected $fillable = [
        'name','status'
    ];
}
