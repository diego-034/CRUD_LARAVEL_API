<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    protected $primaryKey = 'invoiceDetailsId';
    protected $fillable  = ['productId','quantity','total','state','invoiceId'];
}
