<?php
session_start();

define("__ROOT__", __DIR__ . "/../");
include "../assets/functions.php";
include "../assets/autoload.php";

try {
    $autoload = new Autoload([
        ".", 
        "core", 
        "controller", 
        "model", 
        "view"
    ]);
    $autoload->registrar();

    FrontController::procesarSolicitud();
} catch (Exception $e) {
    ErrorView::show($e);
}
