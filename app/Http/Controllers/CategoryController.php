<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $data['categories'] = $categories;
        if ($data['categories'] == null) {
            return $this->sendError("Error en consultra categorias");
        }
        return $this->sendResponse($data, "Información Categorias obtenidas");
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
            'category' => 'required|string',
            'state' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            return $this->sendError("Error de ingreso de categoría", $validator->errors(), 422);
        }
        $input = $request->all();
        $data['category'] = Category::create($input);

        return $this->sendResponse($data, "Categoría ingresado exitosamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update($categoryId, Request $request /*, Category $category*/)
    {
        $category = Category::find($categoryId);
        if ($category == null) {
            return $this->sendError("Error en los datos", ["La categoría no existe"], 422);
        }
        $validator = Validator::make($request->all(), [
            'category' => 'required|string',
            'state' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            return $this->sendError("error de validación", $validator->errors(), 422);
        }
        $category->category = $request->get("category");
        $category->state = $request->get("state");
        $category->save();
        return $this->sendResponse($category, "Datos actualizados exitosamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($categoryId, Category $category)
    {
        $categori = Category::find($categoryId);
        if ($categori == null) {
            return $this->sendError("Error en los datos", ["El tipo de usuario no existe"], 422);
        }
        $categori->state = false;
        $categori->save();
        return $this->sendResponse($categori, "Tipo de usuario eliminado exitosamente");
    }
}
