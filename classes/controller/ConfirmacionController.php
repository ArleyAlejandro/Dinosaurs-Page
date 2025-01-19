<?php

class ConfirmacionController
{

    public function __construct()
    {}

    public function show($params = null)
    {

        $vHome = new ConfirmacionView();
        $vHome->show();

    }
// Funcion para hacer el update en la base de datos, tambien he agregado una verificacion en el front controller 
// para verifica si se envia por la url confirmacion/confirmarCorreo
    public function confirmarCorreo()
    {

        $actualizarEstado = new AdminUser();
        $data             = ["email" => $_SESSION['usuario']];
        $actualizarEstado->editStatus($data);

        header("Location: index.php");
        exit();
    }
}
