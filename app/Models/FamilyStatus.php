<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyStatus extends Model
{
    public $table = 'family_status';
    protected $fillable = [
        'name','status'
    ];
}
