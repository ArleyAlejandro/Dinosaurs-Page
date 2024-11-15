<?php
session_start(); 

// Definir variables para almacenar los posibles errores
$errores = [];
$nom = $cognoms = $contrasenya = '';

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    function sanatizar($datos) {
        $datos = trim($datos);
        $datos = stripslashes($datos);
        $datos = htmlspecialchars($datos, ENT_QUOTES, 'UTF-8');
        return $datos;
    }
    
    function validarContrasena($contrasena) {
        if (strlen($contrasena) < 8) return false;
        if (!preg_match('/[A-Z]/', $contrasena)) return false;
        if (!preg_match('/[a-z]/', $contrasena)) return false;
        if (!preg_match('/[0-9]/', $contrasena)) return false;
        if (!preg_match('/[\W_]/', $contrasena)) return false;
        return true;
    }
    
    // Obtener los datos del formulario y sanitizarlos
    $nom = sanatizar(trim($_POST['nom'] ?? ''));
    $cognoms = sanatizar(trim($_POST['cognoms'] ?? ''));
    $contrasenya = sanatizar($_POST['contrasenya'] ?? '');
    
    // Validar que los campos no estén vacíos
    if (empty($nom)) {
        $errores['nom'] = "El campo de nombre es obligatorio.";
    }
    
    if (empty($cognoms)) {
        $errores['cognoms'] = "El campo de apellidos es obligatorio.";
    }
    
    if (empty($contrasenya)) {
        $errores['contrasenya'] = "El campo de contraseña es obligatorio.";
    } elseif (!validarContrasena($contrasenya)) {
        $errores['contrasenya'] = "La contraseña debe tener al menos 8 caracteres, incluir mayúsculas, minúsculas, números y caracteres especiales.";
    }
    
    // Si no hay errores, procesar la información
    if (empty($errores)) {
        $_SESSION['usuario'] = $nom;
        $_SESSION['apellidos'] = $cognoms;
        header("Location: bolsa.php");  
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Página de Login</title>
    <link rel="stylesheet" href="../CSS/Web.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="login">
    <form class="form" method="post" action="login.php">
        <p class="title">Login</p>

        <!-- Nombre -->
        <label>
            <input class="input" type="text" name="nom" placeholder="Nombre" value="<?= htmlspecialchars($nom) ?>">
            <span>Nombre<span style="color:red;"> (*)</span></span>
        </label>
        <?php if (!empty($errores['nom'])): ?>
            <p class="error"><?= $errores['nom'] ?></p>
        <?php endif; ?>

        <!-- Apellidos -->
        <label>
            <input class="input" type="text" name="cognoms" placeholder="Apellidos" value="<?= htmlspecialchars($cognoms) ?>">
            <span>Apellidos<span style="color:red;"> (*)</span></span>
        </label>
        <?php if (!empty($errores['cognoms'])): ?>
            <p class="error"><?= $errores['cognoms'] ?></p>
        <?php endif; ?>

        <!-- Contraseña -->
        <label>
            <input class="input" type="password" name="contrasenya" placeholder="Contraseña">
            <span>Contraseña<span style="color:red;"> (*)</span></span>
        </label>
        <?php if (!empty($errores['contrasenya'])): ?>
            <p class="error"><?= $errores['contrasenya'] ?></p>
        <?php endif; ?>

        <!-- Error general -->
        <?php if (!empty($errores['login'])): ?>
            <p class="error"><?= $errores['login'] ?></p>
        <?php endif; ?>

        <button class="submit" type="submit">Enviar</button>

        <p class="signin">
            ¿No tienes cuenta? <a href="registro.php">Regístrate</a>
        </p>

        <p class="signin"><a href="Home.php">Regresar al home</a></p>
    </form>
</body>
</html>
