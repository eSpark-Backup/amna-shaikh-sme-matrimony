<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Religion extends Model
{
	public $table = 'religion';
    protected $fillable = [
        'name','status'
    ];
}
