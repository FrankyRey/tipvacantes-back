<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\CategoriaVacante;
use App\Http\Middleware\ApiAuthMiddleware;

use Illuminate\Support\Facades\Validator;

class CategoriaVacanteController extends Controller
{
    public function __construct() {
        $this->middleware('api.auth')->except(['index','show']);
    }

    public function index(){
        $categoriasVacantes = CategoriaVacante::all();

        return response()->json([
            'code'      => 200,
            'status'    => 'success',
            'categoriasVacantes' => $categoriasVacantes
        ]);
    }

    public function show($id) {
        $categoriaVacante = CategoriaVacante::find($id);

        if(is_object($categoriaVacante)) {
            $data = array(
                'code'      => 200,
                'status'    => 'success',
                'categoriaVacante' => $categoriaVacante
            );
        } else {
            $data = array(
                'code'      => 404,
                'status'    => 'error',
                'message' => 'La categoria no existe'
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
                    'message'   => 'No se ha creado la categoria'
                );
            } else {
                $categoriaVacante = new CategoriaVacante();
                $categoriaVacante->nombre = $params_array['nombre'];
                $categoriaVacante->descripcion = isset($params_array['descripcion']) ? $params_array['descripcion']:null;
                $categoriaVacante->save();

                $data = array(
                    'code'      => 200,
                    'status'    => 'success',
                    'categoriaVacante' => $categoriaVacante
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
                    'message'   => 'No se ha actualizado la categoria'
                );
            } else {
                //Quitar los datos que no quiero actualizar
                unset($params_array['id']);
                unset($params_array['created_at']);

                //Guardar los datos
                $categoriaVacante = CategoriaVacante::where('id', $id)->update($params_array);

                $data = array(
                    'code'      => 200,
                    'status'    => 'success',
                    'categoriaVacante' => $params_array
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
        $categoriaVacante = CategoriaVacante::find($id);

        //Borrarlo
        if(is_object($categoriaVacante)) {
            $categoriaVacante->delete();

            $data = array(
                'code'      => 200,
                'status'    => 'success',
                'categoriaVacante' => $categoriaVacante
            );
        } else {
            $data = array(
                'code'      => 404,
                'status'    => 'error',
                'message'   => 'La categoria no existe'
            );

        }

        //Devolver datos
        return response()->json($data, $data['code']);
    }
}
