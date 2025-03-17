<?php

class ErrorView
{
    public static function show($e)
    {
        echo '<!DOCTYPE html>
<html lang="es">
            
<head>
    <meta charset="UTF-8" />
    <title>Home-Dinosaurios</title>
    <link rel="stylesheet" href="../CSS/Web.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Arley Rodríguez">
    <meta name="description" content="Actividad Final de Módulo \'Llenguatges de marques i sistemes de gestió d\'informació\'">
</head>
            
<body>
    <div class="contenedor">
        <div class="menu-nav">
            <header>
                <h1>Descubriendo el Mundo de los Dinosaurios</h1>
                <nav class="contenedor-menu">
                    <ul class="menu">
                        <li><a href="" id="inicio">Inicio</a></li>
                        <li><a href="?Caracteristiques/show">Características</a></li>
                        <li><a href="?Conclusion/show">Conclusión</a></li>
                        <li><a href="?login/show">Login</a>
                            <ul>
                                <li><a href="?registro/show">Registro</a></li>
                            </ul>
                        </li>
                        <li><a href="?bolsa/show">Bolsa</a></li>
                        <li><a href="?Calendar/show">Calendario</a></li>
                        <li><a href="?Mantenimiento/show">Mantenimiento</a></li>
                    </ul>
                </nav>
            </header>
        </div>
            
        <div class="menu-principal">
        <p style="color: red; font-weight: bold; font-size: 18px;">Error:</p>
        <p style="color: darkred; font-style: italic; font-size: 16px;">' . htmlspecialchars($e->getMessage()) . '</p>

        </div>
    </div>
</body>
                
</html>';
    }
}
