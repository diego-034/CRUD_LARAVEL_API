<?php

namespace App\Http\Controllers;

use App\InvoiceDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoicesDetails = InvoiceDetails::all();
        $data['invoicesDetails'] = $invoicesDetails;

        if ($data['invoicesDetails'] == null) {
            return $this->sendError("Error en consultar Detalles de Facturas");
        }
        return $this->sendResponse($data, "Información de Detalles de Facturas existentes");
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
            'productId' => 'required|integer', 
            'quantity' => 'required|integer',
            'total' => 'required|numeric', 
            'state' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            return $this->sendError("Error de validación de datos", $validator->errors(), 422);
        }
        $input = $request->all();
        $data['invoiceDetails'] = InvoiceDetails::create($input);

        return $this->sendResponse($data, "Detalles de Factura ingresados exitosamente");
    }

    private static function addTotal(){
        
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\InvoiceDetails  $invoiceDetails
     * @return \Illuminate\Http\Response
     */
    public function show(InvoiceDetails $invoiceDetails)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InvoiceDetails  $invoiceDetails
     * @return \Illuminate\Http\Response
     */
    public function update($invoiceDetailId, Request $request, InvoiceDetails $invoiceDetails)
    {
        $invoiceDetail = InvoiceDetails::find($invoiceDetailId);
        if ($invoiceDetail == null) {
            return $this->sendError("Error en los datos", ["El tipo de detalle no existe en alguna factura"], 422);
        }
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer',
            'state' => 'required|boolean',
            'total' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return $this->sendError("error de validación", $validator->errors(), 422);
        }
        $invoiceDetail->quantity = $request->get("quantity");
        $invoiceDetail->state = $request->get("state");
        $invoiceDetail->total = $request->get("total");

        $invoiceDetail->save();
        return $this->sendResponse($invoiceDetail, "Datos actualizados exitosamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InvoiceDetails  $invoiceDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy($invoiceDetailId, InvoiceDetails $invoiceDetails)
    {
        $invoiceDetail = InvoiceDetails::find($invoiceDetailId);
        if ($invoiceDetail == null) {
            return $this->sendError("Error en los datos", ["El tipo de usuario no existe"], 422);
        }
        $invoiceDetail->state = false;
        $invoiceDetail->save();
        return $this->sendResponse($invoiceDetail, "Tipo de usuario eliminado exitosamente");
    }
}
