<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersType extends Model
{
    protected $primaryKey = 'typeId';
    protected $fillable  = ['type','state'];
}
