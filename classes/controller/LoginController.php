<?php

class LoginController
{

    public function __construct()
    {}

    public function show($params = null)
    {

        $vlogin = new LoginView();
        $vlogin->show();

    }

    public function form($params)
    {
        // Objeto para hacer una consulta a la base de
        $consultaEmail = new QueryUser();

        // Validar que el campo de email no esté vacío
        if (empty($params["email"])) {
            $errors['email'] = "El campo de email es obligatorio.";
        } elseif (! filter_var($params["email"], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "El formato del email no es válido.";
        } elseif (!$consultaEmail->emailExists($params["email"])) {
            $errors['email'] = "El email no está registrado.";
        }  else {
            $email = strtolower($params["email"]);
        }

        // Instancar la clase AdminUser para hacer una consulta a la base de datos 
        $consultaPass = new AdminUser();
        $consultaPass->get($email);

        if (empty($params["contrasenya"])) {
            $errors['contrasenya'] = "El campo de contraseña es obligatorio.";
        } 
        elseif (! validarContrasena($params["contrasenya"])) {
            $errors['contrasenya'] = "La contraseña debe tener al menos 8 caracteres, incluir mayúsculas, minúsculas, números y caracteres especiales.";
        } 
        elseif(!password_verify($params["contrasenya"], $consultaPass->contraseña)) {
            $errors['contrasenya'] = "La contraseña no es correcta.";
        } else {
            $pass = $params["contrasenya"];
        }

        $login = new LoginModel($email, $pass);

        if (! empty($errors)) {
            $login->errors = $errors; 
        }else{

            $_SESSION['usuario_logueado'] = true;
            $_SESSION['nombre'] = $consultaPass->nombre . " " . $consultaPass->apellidos;

            unset($_SESSION["mensajeDeRedireccion"]);
            header("Location: index.php"); 
        }
        
        $vlogin = new LoginView();
        $vlogin->form($login);
    }
}
