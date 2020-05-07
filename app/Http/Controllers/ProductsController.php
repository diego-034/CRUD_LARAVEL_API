<?php

namespace App\Http\Controllers;

use App\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::all();
        $data['products'] = $products;

        if ($data['products'] == null) {
            return $this->sendError("Error en consultar productos");
        }
        return $this->sendResponse($data, "Información Productos existentes");
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
            'name' => 'required|string',
            'stock' => 'required|integer',
            'total' => 'required|numeric',
            'categoryId' => 'required|integer',
            'IVA' => 'required|numeric',
            'state' => 'required|numeric'
        ]);
        //
        if ($validator->fails()) {
            return $this->sendError("Error de ingreso de producto", $validator->errors(), 422);
        }
        $input = $request->all();
        $data['product'] = Products::create($input);

        return $this->sendResponse($data, "Producto ingresado exitosamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update($productId, Request $request, Products $products)
    {
        $product = Products::find($productId);
        if ($product == null) {
            return $this->sendError("Error en los datos", ["El producto no existe"], 422);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'stock' => 'required|integer',
            'total' => 'required|numeric',
            'IVA' => 'required|numeric',
            'state' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return $this->sendError("error de validación", $validator->errors(), 422);
        }
        $product->name = $request->get("name");
        $product->stock = $request->get("stock");
        $product->total = $request->get("total");
        $product->IVA = $request->get("IVA");
        $product->state = $request->get("state");
        $product->save();
        return $this->sendResponse($product, "Datos actualizados exitosamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy($productId, Products $products)
    {
        $product = Products::find($productId);
        if ($product == null) {
            return $this->sendError("Error en los datos", ["El producto no existe"], 422);
        }
        $product->state = false;
        $product->save();
        return $this->sendResponse($product, "Producto eliminado exitosamente");
    }
}
