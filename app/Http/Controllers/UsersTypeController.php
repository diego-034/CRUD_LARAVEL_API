<?php

namespace App\Http\Controllers;

use App\UsersType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usersTypes = UsersType::all();
        $data['usersTypes'] = $usersTypes;
        if ($data['usersTypes'] == null) {
            return $this->sendError("Error en consultar Tipos de usuarios");
        }
        return $this->sendResponse($data, "Información Tipos de usuarios");
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
            'type' => 'required',
            'state' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            return $this->sendError("Error de validación de datos", $validator->errors(), 422);
        }
        $input = $request->all();
        $data['userType'] = UsersType::create($input);

        return $this->sendResponse($data, "Tipo de usuario ingresado exitosamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UsersType  $usersType
     * @return \Illuminate\Http\Response
     */
    public function show(UsersType $usersType)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UsersType  $usersType
     * @return \Illuminate\Http\Response
     */
    public function update($userTypeId, Request $request, UsersType $usersType)
    {
        $userType = UsersType::find($userTypeId);
        if ($userType == null) {
            return $this->sendError("Error en los datos", ["El tipo de usuario no existe"], 422);
        }
        $validator = Validator::make($request->all(), [
            'type' => 'required|string',
            'state' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            return $this->sendError("error de validación", $validator->errors(), 422);
        }
        $userType->type = $request->get("type");
        $userType->state = $request->get("state");
        $userType->save();
        return $this->sendResponse($userType, "Datos actualizados exitosamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UsersType  $usersType
     * @return \Illuminate\Http\Response
     */
    public function destroy($userTypeId, UsersType $usersType)
    {
        $userType = UsersType::find($userTypeId);
        if ($userType == null) {
            return $this->sendError("Error en los datos", ["El tipo de usuario no existe"], 422);
        }
        $userType->state = false;
        $userType->save();
        return $this->sendResponse($userType, "Tipo de usuario eliminado exitosamente");
    }
}
