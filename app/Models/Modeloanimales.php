<?php namespace App\Models;

use CodeIgniter\Model;

class Modeloanimales extends Model
{
    protected $table      = 'animales';
    protected $primaryKey = 'id';

    protected $allowedFields = array('nombre', 'edad', 'tipoanimal', 'descripcion', 'comida', 'foto');
}