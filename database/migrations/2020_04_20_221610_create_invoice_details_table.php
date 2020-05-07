<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->increments('invoiceDetailsId');
            $table->unsignedInteger('productId');
            $table->foreign('productId')->references('productId')->on('products');
            $table->integer('quantity');
            $table->decimal('total',11,2);
            $table->boolean('state');
            $table->unsignedInteger('invoiceId');
            $table->foreign('invoiceId')->references('invoiceId')->on('invoices');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_details');
    }
}
