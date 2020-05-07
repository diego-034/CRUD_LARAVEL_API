<?php

namespace App\Http\Controllers;

use App\Invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoices::all();
        $data['invoices'] = $invoices;

        if ($data['invoices'] == null) {
            return $this->sendError("Error en consultar Facturas");
        }
        return $this->sendResponse($data, "Información Facturas existentes");
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'total' => 'required|numeric', 
            'state' => 'required|boolean',
            'stateInvoice' => 'required|boolean',
            'userId' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return $this->sendError("Error de validación de datos", $validator->errors(), 422);
        }
        $input = $request->all();
        $data['invoice'] = Invoices::create($input);

        return $this->sendResponse($data, "Factura ingresada exitosamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show(Invoices $invoices)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update($invoiceId, Request $request, Invoices $invoices)
    {
        $invoice = Invoices::find($invoiceId);
        if ($invoice == null) {
            return $this->sendError("Error en los datos", ["La factura no existe"], 422);
        }
        $validator = Validator::make($request->all(), [
            'total' => 'required|numeric', 
            'state' => 'required|boolean',
            'stateInvoice' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            return $this->sendError("error de validación", $validator->errors(), 422);
        }
        $invoice->total = $request->get("total");
        $invoice->state = $request->get("state");
        $invoice->stateInvoice = $request->get("stateInvoice");

        $invoice->save();
        return $this->sendResponse($invoice, "Datos actualizados exitosamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy($invoiceId, Invoices $invoices)
    {
        $invoice = Invoices::find($invoiceId);
        if ($invoice == null) {
            return $this->sendError("Error en los datos", ["La factura no existe"], 422);
        }
        $invoice->state = false;
        $invoice->save();
        return $this->sendResponse($invoice, "Factura eliminada exitosamente");
    }
}
