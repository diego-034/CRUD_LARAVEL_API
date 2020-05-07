<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $primaryKey = 'productId';
    protected $fillable  = ['name','stock','total','categoryId','IVA','state'];
}
