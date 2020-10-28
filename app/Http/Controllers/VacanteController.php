<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\Vacante;

use App\Http\Middleware\ApiAuthMiddleware;

use Illuminate\Support\Facades\Validator;

class VacanteController extends Controller
{
    public function __construct() {
        $this->middleware('api.auth')->except(['index','show']);
    }

        public function index(){
            $vacante = Vacante::all();
        return response()->json([
        'code'      => 200,
        'status'    => 'success',
        'vacante' => $vacante]);
    }

        public function show($id) {
        $vacante = Vacante::find($id);

        if(is_object($vacante)) {
        $data = array(
            'code'      => 200,
            'status'    => 'success',
            'vacante' => $vacante
            );
    }   else {
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
            'titulo'    => 'required',
            'genero'    => 'required',
            ]);

            //Guardar los datos
            if($validate->fails()){
                $data = array(
                    'code'      => 400,
                    'status'    => 'error',
                    'message'   => 'No se ha creado la categoria'
                );
            } else {
                $vacante= new Vacante();
                $vacante->titulo = $params_array['titulo'];
                $vacante->genero = $params_array['genero'];
                $vacante->descripcion = isset($params_array['descripcion']) ? $params_array['descripcion']:null;
                $vacante->image = isset($params_array['image']) ? $params_array['image']:null;
                $vacante->fecha_inicio = isset($params_array['fecha_inicio']) ? $params_array['fecha_inicio']:null;
                $vacante->fecha_fin = isset($params_array['fecha_fin']) ? $params_array['fecha_fin']:null;
                $vacante->edad_minima = isset($params_array['edad_minima']) ? $params_array['edad_minima']:null;
                $vacante->edad_maxima = isset($params_array['edad_maxima']) ? $params_array['edad_maxima']:null;
                $vacante->sueldo = isset($params_array['sueldo']) ? $params_array['sueldo']:null;
                $vacante->cantidad = isset($params_array['cantidad']) ? $params_array['cantidad']:null;
                $vacante->escolaridad = isset($params_array['escolaridad']) ? $params_array['escolaridad']:null;
                $vacante->area_estudio = isset($params_array['area_estudio']) ? $params_array['area_estudio']:null;
                $vacante->categoria_vacante = isset($params_array['categoria_vacante']) ? $params_array['categoria_vacante']:null;
                $vacante->cliente = isset($params_array['cliente']) ? $params_array['cliente']:null;
                $vacante->usuario = isset($params_array['usuario']) ? $params_array['usuario']:null;
                $vacante->save();
                $data = array(
                    'code'      => 200,
                    'status'    => 'success',
                    'vacante' => $vacante
                );
            }
        } else {
            $data = array(
                'code'      => 400,
                'status'    => 'error',
                'message'   => 'No has enviado ningun dato'
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
                'titulo'    => 'required',
                'genero'    => 'required',
            ]);

            if($validate->fails()){
                $data = array(
                    'code'      => 400,
                    'status'    => 'error',
                    'message'   => 'No se ha actualizado la vacante'
                );
            } else {
                //Quitar los datos que no quiero actualizar
                unset($params_array['id']);
                unset($params_array['created_at']);

                //Guardar los datos
                $vacante = Vacante::where('id', $id)->update($params_array);

                $data = array(
                    'code'      => 200,
                    'status'    => 'success',
                    'vacante' => $params_array
                );
            }
        }   else {
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
        $vacante = Vacante::find($id);

        //Borrarlo
        if(is_object($vacante)) {
            $vacante->delete();

            $data = array(
                'code'      => 200,
                'status'    => 'success',
                'vacante' => $vacante
            );
        } else {
            $data = array(
                'code'      => 404,
                'status'    => 'error',
                'message'   => 'La vacante no existe'
            );

        }

        //Devolver datos
        return response()->json($data, $data['code']);
    }
}