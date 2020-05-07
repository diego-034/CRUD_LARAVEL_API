<?php

namespace App\Http\Controllers;

use App\Users;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $data['thisUser'] = $user;
        if ($data['thisUser'] == null) {
            return $this->sendError("Error en consultar el Usuario");
        }
        return $this->sendResponse($data, "Información del usuario logueado");
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
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'state' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            return $this->sendError("error de validación", $validator->errors(), 422);
        }
        $input = $request->all();
        $input["password"] = bcrypt($request->get("password"));
        $data['user'] = Users::create($input);
        $data['token'] = $data['user']->createToken("MyApp")->accessToken;
        return $this->sendResponse($data, "Usuario y Token");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function show(Users $users)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Users $users)
    {
        $userId = Auth::user()->getAuthIdentifier();
        $user = Users::find($userId);
        if ($user == null) {
            return $this->sendError("Error en los datos", ["El usuario no existe"], 422);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'lastName' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'state' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            return $this->sendError("error de validación", $validator->errors(), 422);
        }
        $user->name = $request->get("name");
        $user->lastName = $request->get("lastName");
        $user->phone = $request->get("phone");
        $user->address = $request->get("address");
        $user->state = $request->get("state");
        $user->save();
        return $this->sendResponse($user, "Datos actualizados exitosamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function destroy(Users $users)
    {
        $userId = Auth::user()->getAuthIdentifier();
        $user = Users::find($userId);
        if ($user == null) {
            return $this->sendError("Error en los datos", ["El usuario no existe"], 422);
        }
        $user->state = false;
        $user->save();
        return $this->sendResponse($user, "Usuario eliminado exitosamente");
    }
}
