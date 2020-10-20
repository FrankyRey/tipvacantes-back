<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class UserController extends Controller
{
    //
    public function pruebas() {
        return "Acción de pruebas de USER-CONTROLLER";
    }

    public function register(Request $request) {

        //Recoger los datos del usuario por POST
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        if(!empty($params) && !empty($params_array)) {
            //Limpiar datos
            $params_array = array_map('trim', $params_array);

            //Validar datos
            $validate = Validator::make($params_array, [
                'nombre'    => 'required|alpha',
                'apellidos' => 'required|string',
                'email'     => 'required|email|unique:user',
                'password'  => 'required'
            ]);

            if($validate->fails()) {
                $data = array (
                    'status' => 'error',
                    'code'   => '404',
                    'message' => 'El usuario no se ha creado',
                    'errors'  => $validate->errors()
                );
            } else {

                //Cifrar la contraseña
                $pwd = password_hash($params->password, PASSWORD_BCRYPT, ['cost' => 4]);

                //Crear el usuario
                $user = new User();
                $user->nombre    =   $params_array['nombre'];
                $user->apellidos =   $params_array['apellidos'];
                $user->email     =   $params_array['email'];
                $user->password  =   $pwd;

                $user->save();

                $data = array (
                    'status' => 'success',
                    'code'   => '200',
                    'message' => 'El usuario se ha creado',
                );
            }
        } else {
            $data = array(
                'status' => 'success',
                'code'   => '400',
                'message' => 'Error'
            );
        }

        return response()->json($data, $data['code']);
    }

    public function login(Request $request) {
        return "Acción de login de usuarios";
    }
}
