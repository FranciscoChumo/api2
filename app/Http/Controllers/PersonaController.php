<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
/**
* @OA\Info(
*             title="Api de personas", 
*             version="1.0",
*             description="listado de la api persona"
* )
*
* @OA\Server(url="http://127.0.0.1:8000")
*/
class PersonaController extends Controller
{
    /**
     * Muestra de todos los datos personas
     * @OA\Get (
     *     path="/api/auth/persona",
     *     tags={"persona"},
     *     @OA\Response(
     *         response=200,
     *         description="ejecucion perfecta",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="rows",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="nombres",
     *                         type="string",
     *                         example="rafael"
     *                     ),
     *                     @OA\Property(
     *                         property="cedula",
     *                         type="string",
     *                         example="111111111"
     *                     ),
     *                     @OA\Property(
     *                         property="direccion",
     *                         type="string",
     *                         example="Bolivar"
     *                     ),
     *                     @OA\Property(
     *                         property="fecha_nacimiento",
     *                         type="string",
     *                         example="2023-02-10"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function mostrardatos()
    {
        $datos = DB::table('personas')//la tabla que se pone aqui  tiene que estar relacionada solo una vez
        ->join('users', 'personas.id', '=', 'users.persona_id')// de nuestra tabla user que se encuetra persona.id donde es = a la tabla user.personas_id
        ->join('rols', 'users.id', '=', 'rols.id')
        ->select('personas.*', 'users.name', 'rols.rol')
        ->where('personas.estado',true)//donde la tabla personas dentro de ella esta estado la cual si no quieres no la llamas al modelo con el solo true
        ->get();

        return response()->json(['datos'=>$datos]);
    }

    public function eliminar($id){ //es un eliminado logico no permanente
        $persona= Persona::find($id);//find cuando queremos traer o mostrar un solo valor en este caso por el id
        if($persona->estado==false){//validamos el estado si ya a sido eliminado
        return response()->json(['message'=>"El Registro ya se a eliminado anteriormente"]);
        }
        $persona->estado=false;
        $persona->save();// en nuestra variable persona se guarde los datos
        return response()->json(['message'=>" Registro eliminado correctamente"]);//toda esta linea de codigo es para que nos muestre un mensaje 
    }

    public function actualizar (Request $request,$id){
        if(empty($request->nombre)||empty($request->cedula)||empty($request->direccion)||empty($request->fecha_nacimiento)){
            return response()->json(['message'=>" No se permiten campos vacios"]); 
        }
        if(empty($id)){
            return response()->json(['message'=>" El id no se permite vacio ingrese un id"]);
        }
       $persona= Persona::find($id);
       if($persona->estado==false){//validamos el estado si ya a sido eliminado
        return response()->json(['message'=>"El Registro ya se a eliminado anteriormente"]);
        }
        $persona->nombre=$request->nombre;
        $persona->cedula=$request->cedula;
        $persona->direccion=$request->direccion;
        $persona->nombrefecha_nacimiento=$request->fecha_nacimiento;

        $persona->save();
        return response()->json(['message'=>"El Registro se a actulizado correctamente"]);

    }
}
