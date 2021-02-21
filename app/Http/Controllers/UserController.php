<?php

namespace App\Http\Controllers;

use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserController extends Controller
{
    //Muestra un registro de todos los usuarios que hay en el sistema
    public function index()
    {
        try {
            //Obtenemos el registro de todos los usuarios
            $users = Users::all();
            //Retornamos los valores que han sido guardados en la variable $users
            return $users;
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }
    
    //Crea una cuenta en el sistema
    public function store(Request $request)
    {   
        //Validamos que los datos hayan sido ingresados por el usuario no esten vacios
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);
        //Encriptamos el password ingresado por el usuario
        $validated['password'] = Hash::make($request->password);
        //Registramos al usuario
        Users::create($validated);
        //Mostramos un mensaje al usuario, indicandole que su cuenta fue registrada correctamente
        return response() -> json([
            'res' => true,
            'message' => 'Usuario creado correctamente !'
        ], 200);
    }

    public function login(Request $request)
    {
        //Validamos que los datos hayan sido ingresados por el usuario no esten vacios
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        //Obtenemos el email ingresado por el usuario
        $users = Users::whereEmail($validated["email"])->first();
        //Verificamos que los datos que a ingresado el usuario sean los correctos
        if(!is_null($users) && Hash::check($validated["password"], $users->password)){
            //Creamos el token de forma aleatoria
            $users->api_token = Str::random(100);
            //Guardamos los datos que han sido ingresados por el usuario
            $users->save();
            //Enviamos un mensaje al usuario, indicandole que los datos ingresados fueron correctos
            return response()->json([
                'res' => true,
                'token' => $users->api_token,
                'message' => 'User logged in successfully !!'
            ],200);
        }else{
            //Enviamos un mensaje al usuario, indicandole que los datos ingresados son incorrectos
            return response()->json([
                'res' => false,
                'message' => 'Incorrect account or password.'
            ],200);
        }
    }

    //Actualiza el perfil de un usuario
    public function updateProfile(Request $request, int $id)
    {
        //Obtenemos el id del usuario que va a actualizar su perfil
        $users = Users::find($id);
        //Validamos que los datos hayan sido ingresados por el usuario
        $validated = $request->validate([
            'name' => 'required',
            'fatherlastname' => 'required',
            'motherlastname' => 'required',
            'email' => 'required'
        ]);
        //Obtenemos los datos que el usuario va a modificar
        $users->name = $validated["name"];
        $users->fatherlastname = $validated["fatherlastname"];
        $users->motherlastname = $validated["motherlastname"];
        $users->email = $validated["email"];
        //Actualizamos la información del usuario
        $users->update();
        //Enviamos un mensaje al usuario, indicandole que se modifico correctamente sus datos
        return response()->json([
            'message' => 'Data updated correctly !!'
        ]);
    }

    //Elimina una cuenta de usuario
    public function destroyAccount(int $id)
    {
        try {
            //Eliminamos la cuenta que esta asociada al identificador que a sido ingresado por el usuario
            Users::destroy($id);
            //Mostramos un mensaje al usuario, indicandole que la cuenta a sido eliminada correctamente
            return response()->json([
                'res' => true,
                'message' => 'Account deleted successfully !!'
            ]);
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    //Cierra session de usuario
    public function logout()
    {
        try {
            //Obtenemos la sesion del usuario
            $users= auth()->user();
            //Indicamos que el token del usuario que a iniciado sesion va a ser nulo
            $users->api_token = null;
            //Actualizamos y guardamos el token del usuario
            $users->save();
            //Mostramos un mensaje al usuario, indicandole que a cerrado sesión correctamente
            return response()->json([
                'res' => true,
                'message' => 'Session closed successfully !!'
            ]);
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }
}