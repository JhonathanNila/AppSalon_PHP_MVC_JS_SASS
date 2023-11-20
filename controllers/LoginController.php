<?php

namespace Controllers;

use MVC\Router;
use Classes\Email;
use Model\Usuario;

class LoginController {
    public static function login(Router $router) {
        $alertas = [];
        $auth = new Usuario;
        if($_SERVER['REQUEST_METHOD'] === "POST") {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();
            if(empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);
                if($usuario) {
                    if($usuario->comprobarPasswordAndVerificado($auth->password)){
                        \session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;
                        if($usuario->admin === "1"){
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        }else {
                            header('Location: /cita');
                        }
                        \debuguear($_SESSION);
                    }
                }else {
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/login', [
            'alertas' => $alertas,
            'auth' => $auth
        ]);
    }
    public static function logout() {
        echo "Desde Logout";
    }
    public static function olvide(Router $router) {
        $router->render('auth/olvide-password');
    }
    public static function recuperar() {
        echo "Desde recuperar";
    }
    public static function crear(Router $router) {
        $usuario = new Usuario($_POST);
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === "POST") {
            $usuario->sincronizar();
            $alertas = $usuario->validarNuevaCuenta();
            if(empty($alertas)) {
                $resultado = $usuario->existeUsuario();
                if($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    $usuario->hashPassword();
                    $usuario->crearToken();
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarConfirmacion();
                    $resultado = $usuario->guardar();
                    if($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }
        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }
    public static function mensaje(Router $router) {
        $router->render('auth/mensaje');
    }
    public static function confirmar(Router $router) {
        $alertas = [];
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);
        if(empty($usuario)) {
            Usuario::setAlerta('error', 'Token no válido');
        }else {
            $usuario->confirmado = "1";
            $usuario->token = '';
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta Verificada Exitosamente');
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
}
