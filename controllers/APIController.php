<?php

namespace Controllers;

use Model\Cita;
use Model\Servicio;
use Model\CitaServicio;

class APIController {
    public static function index() {
        $servicios = Servicio::all();
        echo \json_encode($servicios);
    }

    public static function guardar() {
        // Almacena cita y devuelve el ID
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();
        $id = $resultado['id'];
        // Almacena los Servicios con el ID de la cita
        $idServicios = \explode(",", $_POST['servicios']);
        foreach($idServicios as $idServicio) {
            $args = [
                'citaID' => $id,
                'servicioID' => $idServicio
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }
        echo json_encode(['resultado' => $resultado]);
    }
}