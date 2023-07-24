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
        $datos = DB::table('personas')
        ->join('users', 'personas.id', '=', 'users.persona_id')
        ->join('rols', 'users.id', '=', 'rols.id')
        ->select('personas.*', 'users.name', 'rols.rol')
        ->get();

        return response()->json(['datos'=>$datos]);
    }

    
}
