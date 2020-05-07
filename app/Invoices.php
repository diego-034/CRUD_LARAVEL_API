<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    protected $primaryKey = 'invoiceId';
    protected $fillable  = ['total','state','stateInvoice','userId'];
}
