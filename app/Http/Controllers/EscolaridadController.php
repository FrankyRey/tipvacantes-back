<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\Escolaridad;
use App\Http\Middleware\ApiAuthMiddleware;

use Illuminate\Support\Facades\Validator;

class EscolaridadController extends Controller
{
    public function __construct() {
        $this->middleware('api.auth')->except(['index','show']);
    }

    public function index(){
        $escolaridades = Escolaridad::all();

        return response()->json([
            'code'      => 200,
            'status'    => 'success',
            'escolaridades' => $escolaridades
        ]);
    }

    public function show($id) {
        $escolaridad = escolaridad::find($id);

        if(is_object($escolaridad)) {
            $data = array(
                'code'      => 200,
                'status'    => 'success',
                'escolaridad' => $escolaridad
            );
        } else {
            $data = array(
                'code'      => 404,
                'status'    => 'error',
                'message' => 'La escolaridad no existe'
            );
        }

        return response()->json($data, $data['code']);
    }

    public function store(Request $request) {
        //Recoger los datos por POST
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if(!empty($params_array)){
            //Validar los datos
            $validate = Validator::make($params_array, [
                'nombre'    => 'required',
            ]);

            //Guardar los datos
            if($validate->fails()){
                $data = array(
                    'code'      => 400,
                    'status'    => 'error',
                    'message'   => 'No se ha creado la escolaridad'
                );
            } else {
                $escolaridad = new Escolaridad();
                $escolaridad->nombre = $params_array['nombre'];
                $escolaridad->descripcion = isset($params_array['descripcion']) ? $params_array['descripcion']:null;
                $escolaridad->save();

                $data = array(
                    'code'      => 200,
                    'status'    => 'success',
                    'escolaridad' => $escolaridad
                );
            }
        } else {
            $data = array(
                'code'      => 400,
                'status'    => 'error',
                'message'   => 'No has enviado ningún dato'
            );
        }

        //Devolver resultado
        return response()->json($data, $data['code']);
    }

    public function update($id, Request $request) {
        //Recoger los datos por POST
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if(!empty($params_array)){
            //Validar los datos
            $validate = Validator::make($params_array, [
                'nombre'    => 'required',
            ]);

            if($validate->fails()){
                $data = array(
                    'code'      => 400,
                    'status'    => 'error',
                    'message'   => 'No se ha actualizado la escolaridad'
                );
            } else {
                //Quitar los datos que no quiero actualizar
                unset($params_array['id']);
                unset($params_array['created_at']);

                //Guardar los datos
                $escolaridad = Escolaridad::where('id', $id)->update($params_array);

                $data = array(
                    'code'      => 200,
                    'status'    => 'success',
                    'escolaridad' => $params_array
                );
            }
        } else {
            $data = array(
                'code'      => 400,
                'status'    => 'error',
                'message'   => 'No has enviado ningún dato'
            );
        }

        //Devolver resultado
        return response()->json($data, $data['code']);
    }

    public function destroy($id, Request $request) {
        //Comprobar si existe el registro
        $escolaridad = Escolaridad::find($id);

        //Borrarlo
        if(is_object($escolaridad)) {
            $escolaridad->delete();

            $data = array(
                'code'      => 200,
                'status'    => 'success',
                'escolaridad' => $escolaridad
            );
        } else {
            $data = array(
                'code'      => 404,
                'status'    => 'error',
                'message'   => 'La escolaridad no existe'
            );

        }

        //Devolver datos
        return response()->json($data, $data['code']);
    }
}
