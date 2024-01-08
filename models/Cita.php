<?php

namespace Model;

class Cita extends ActiveRecord {
    protected static $tabla = 'citas';
    protected static $columnasDB = ['id', 'hora', 'fecha', 'usuarioID'];

    public $id;
    public $fecha;
    public $hora;
    public $usuarioID;

    public function __construct ($args = []) {
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->hora = $args['hora'] ?? '';
        $this->usuarioID = $args['usuarioID'] ?? '';
    }
}