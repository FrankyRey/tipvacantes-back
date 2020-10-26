<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\Cliente;

use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    public function __construct() {
        $this->middleware('api.auth')->except(['index','show']);
    }

    public function index() {
        $clientes = Cliente::all();

        $data = array(
            'code'      => 200,
            'status'    => 'success',
            'clientes'  => $clientes
        );

        return response()->json($data, $data['code']);
    }

    public function show($id) {
        $cliente = Cliente::find($id);

        if(is_object($cliente)) {
            $data = array(
                'code'      => 200,
                'status'    => 'success',
                'cliente' => $cliente
            );
        } else {
            $data = array(
                'code'      => 404,
                'status'    => 'error',
                'message' => 'El cliente no existe'
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
                'nombre_empresa'    => 'required',
                'nombre_contacto'    => 'required',
                'correo_empresa'    => 'email',
                'correo_contacto'    => 'required|email',
                'telefono_contacto'    => 'required',
            ]);

            //Guardar los datos
            if($validate->fails()){
                $data = array(
                    'code'      => 400,
                    'status'    => 'error',
                    'message'   => 'No se ha creado el cliente'
                );
            } else {
                $cliente = new Cliente();
                $cliente->nombre_empresa = $params_array['nombre_empresa'];
                $cliente->nombre_contacto = $params_array['nombre_contacto'];
                $cliente->apellidos_contacto = isset($params_array['apellidos_contacto']) ? $params_array['apellidos_contacto']:null;
                $cliente->correo_empresa = isset($params_array['correo_empresa']) ? $params_array['correo_empresa']:null;
                $cliente->correo_contacto = $params_array['correo_contacto'];
                $cliente->telefono_empresa = isset($params_array['telefono_empresa']) ? $params_array['telefono_empresa']:null;
                $cliente->telefono_contacto = $params_array['telefono_contacto'];
                $cliente->calle = isset($params_array['calle']) ? $params_array['calle']:null;
                $cliente->numero = isset($params_array['numero']) ? $params_array['numero']:null;
                $cliente->codigo_postal = isset($params_array['codigo_postal']) ? $params_array['codigo_postal']:null;
                $cliente->localidad = isset($params_array['localidad']) ? $params_array['localidad']:null;
                $cliente->municipio = isset($params_array['municipio']) ? $params_array['municipio']:null;
                $cliente->estado = isset($params_array['estado']) ? $params_array['estado']:null;
                $cliente->save();

                $data = array(
                    'code'      => 200,
                    'status'    => 'success',
                    'cliente' => $cliente
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
                'nombre_empresa'    => 'required',
                'nombre_contacto'    => 'required',
                'correo_empresa'    => 'email',
                'correo_contacto'    => 'required|email',
                'telefono_contacto'    => 'required',
            ]);

            if($validate->fails()){
                $data = array(
                    'code'      => 400,
                    'status'    => 'error',
                    'message'   => 'No se ha actualizado el cliente'
                );
            } else {
                //Quitar los datos que no quiero actualizar
                unset($params_array['id']);
                unset($params_array['created_at']);

                //Guardar los datos
                $cliente = Cliente::where('id', $id)->update($params_array);

                $data = array(
                    'code'      => 200,
                    'status'    => 'success',
                    'areaEstudio' => $params_array
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
        $cliente = Cliente::find($id);

        //Borrarlo
        if(is_object($cliente)) {
            $cliente->delete();

            $data = array(
                'code'      => 200,
                'status'    => 'success',
                'cliente' => $cliente
            );
        } else {
            $data = array(
                'code'      => 404,
                'status'    => 'error',
                'message'   => 'El area de estudio no existe'
            );

        }

        //Devolver datos
        return response()->json($data, $data['code']);
    }
}
