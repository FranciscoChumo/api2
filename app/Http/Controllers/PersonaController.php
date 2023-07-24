<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
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

        return response()->json(['message'=>"El Registro se a actulizado correctamente"]);

    }
}
