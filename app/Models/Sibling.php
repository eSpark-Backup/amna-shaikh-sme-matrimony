<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Sibling extends Model
{
	public $table = 'sibling';
    protected $fillable = [
        'name','status'
    ];
}
