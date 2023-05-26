<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Onbehalf extends Model
{
	public $table = 'on_behalf';
	protected $fillable = [
        'name','status'
    ];
}
