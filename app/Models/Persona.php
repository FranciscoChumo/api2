<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table='personas';
    public $timestamps=false;
    protected $fillable=['nombre','cedula','direccion','fecha_nacimiento'];
}
