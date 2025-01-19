<?php

class ConfirmacionView {
    
    public function __construct() {}
    
    public function show() {
        
        echo '<!DOCTYPE html>
<html lang="es">
            
<head>
<meta charset="UTF-8" />
<title>Home-Dinosaurios</title>
<link rel="stylesheet" href="../CSS/Web.css" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="author" content="Arley Rodríguez">
<meta name="description"
    content="Actividad Final de Módulo \'Llenguatges de marques i sistemes de gestió d\'informació\'">
</head>
            
<body>
   <div class="container">
        <h1>¡Registro Exitoso!</h1>
        <p>Gracias por registrarte en nuestra plataforma. Para completar tu registro, por favor confirma tu dirección de correo electrónico haciendo clic en el siguiente enlace:</p>
        <a href="index.php?confirmacion/confirmarCorreo" class="btn-confirm">Confirmar mi correo</a>
    </div>
</body>
            
</html>';
        
        
    }
}

