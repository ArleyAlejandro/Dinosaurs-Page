<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

session_start();
define("__ROOT__", __DIR__ . "/../");
include "../assets/functions.php";

echo "Usuario: " . $_SESSION['usuario'] . "<br>";
echo "Contraseña: " . $_SESSION['contraseña'] . "<br>";
echo "Usuario logueado: " . $_SESSION['usuario_logueado'] . "<br>";
echo "nombre completo: ". $_SESSION['nombre'] . "<br>";

function my_autoload($classe)
{
    $carpetes = [
        ".",
        "core",
        "controller",
        "model",
        "view",
    ];

    foreach ($carpetes as $carpeta) {
        if (file_exists(__ROOT__ . "classes/$carpeta/$classe.php")) {
            include __ROOT__ . "classes/$carpeta/$classe.php";
            return;
        }
    }
}

function second_autoload($classe)
{
    $carpetes = [
        ".",
        "core",
        "controller",
        "model",
        "view",
    ];

    foreach ($carpetes as $carpeta) {
        if (file_exists(__ROOT__ . "classes/$carpeta/$classe.class.php")) {
            include __ROOT__ . "classes/$carpeta/$classe.class.php";
            return;
        }
    }
    throw new Exception("Definició de classe no trobada $classe");
}

try {
    spl_autoload_register("my_autoload");
    spl_autoload_register("second_autoload");

    FrontController::procesarSolicitud();
} catch (Exception $e) {
    ErrorView::show($e);
}
