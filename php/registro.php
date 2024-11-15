<?php
session_start();

$errores = []; 
$dades = [];  
$imagen = '';  

// Función para sanitizar los datos
function sanatizar($datos) {
    $datos = trim($datos); // Eliminar espacios al principio y al final
    $datos = stripslashes($datos); // Eliminar barras invertidas
    $datos = htmlspecialchars($datos, ENT_QUOTES, 'UTF-8'); // Convertir caracteres especiales a entidades HTML
    return $datos;
}

// Función para validar la contraseña
function validarContrasena($contrasena) {
    // Validar longitud mínima de 8 caracteres
    if (strlen($contrasena) < 8) {
        return false;
    }
    // Validar si contiene al menos una letra mayúscula
    if (!preg_match('/[A-Z]/', $contrasena)) {
        return false;
    }
    // Validar si contiene al menos una letra minúscula
    if (!preg_match('/[a-z]/', $contrasena)) {
        return false;
    }
    // Validar si contiene al menos un número
    if (!preg_match('/[0-9]/', $contrasena)) {
        return false;
    }
    // Validar si contiene al menos un carácter especial
    if (!preg_match('/[\W_]/', $contrasena)) {
        return false;
    }
    return true;
}

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario y sanitizarlos
    $dades = [
        'nom' => sanatizar($_POST['nom'] ?? ''),
        'cognoms' => sanatizar($_POST['cognoms'] ?? ''),
        'usuari' => sanatizar($_POST['usuari'] ?? ''),
        'contrasenya' => $_POST['contrasenya'] ?? '',
        'confirma_contrasenya' => $_POST['confirma_contrasenya'] ?? '',
        'dni' => sanatizar($_POST['dni'] ?? ''),
        'data_naixement' => $_POST['data_naixement'] ?? '',
        'sexe' => $_POST['sexe'] ?? '',
        'codi_postal' => sanatizar($_POST['codi_postal'] ?? ''),
        'poblacio' => sanatizar($_POST['poblacio'] ?? ''),
        'telefon' => sanatizar($_POST['telefon'] ?? ''),
    ];

    // Validar campos obligatorios
    $campos_obligatorios = [
        'nom' => 'Nombre',
        'cognoms' => 'Apellidos',
        'usuari' => 'Usuario',
        'contrasenya' => 'Contraseña',
        'confirma_contrasenya' => 'Confirmación de contraseña',
        'dni' => 'DNI',
        'data_naixement' => 'Fecha de nacimiento',
        'sexe' => 'Sexo',
    ];

    foreach ($dades as $campo => $valor) {
        if (empty($valor) && array_key_exists($campo, $campos_obligatorios)) {
            $errores[$campo] = "El campo {$campos_obligatorios[$campo]} es obligatorio.";
        }
    }

    // Validar que las contraseñas coinciden
    if (!empty($dades['contrasenya']) && $dades['contrasenya'] !== $dades['confirma_contrasenya']) {
        $errores['confirma_contrasenya'] = "Las contraseñas no coinciden.";
    }

    // Validación de la fortaleza de la contraseña
    if (!validarContrasena($dades['contrasenya'])) {
        $errores['contrasenya'] = "La contraseña debe tener al menos 8 caracteres, incluir mayúsculas, minúsculas, números y caracteres especiales.";
    }

    // Validación de DNI
    if (!empty($dades['dni']) && !preg_match('/^\d{8}[A-Za-z]$/', $dades['dni'])) {
        $errores['dni'] = "El DNI debe tener 8 números seguidos de una letra.";
    }

    // Manejar la imagen subida
    if (isset($_FILES['imatge']) && $_FILES['imatge']['error'] === UPLOAD_ERR_OK) {
        // Verificar el tipo de archivo (mime-type)
        $imagen = $_FILES['imatge']['name'];
        $tipoImagen = $_FILES['imatge']['type'];
        $tamanyoImagen = $_FILES['imatge']['size']; // Tamaño del archivo en bytes
        
        // Validar el tipo MIME y la extensión
        $tiposValidos = ['image/jpeg', 'image/png', 'image/gif']; 
        $extensionesValidas = ['jpg', 'jpeg', 'png', 'gif'];  
        
        // Obtener la extensión del archivo subido
        $extensionImagen = strtolower(pathinfo($imagen, PATHINFO_EXTENSION));
        
        // Verificar que el tipo MIME y la extensión del archivo sean válidos
        if (!in_array($tipoImagen, $tiposValidos) || !in_array($extensionImagen, $extensionesValidas)) {
            $errores['imatge'] = "Solo se permiten imágenes en formatos JPG, PNG o GIF.";
        }
        
        // Verificar el tamaño máximo de la imagen (2 MB)
        if ($tamanyoImagen > 2 * 1024 * 1024) { // 2MB = 2 * 1024 * 1024 bytes
            $errores['imatge'] = "El tamaño de la imagen no puede exceder los 2MB.";
        }
        
        // Si el archivo es válido, subirlo
        if (empty($errores)) {
            $directorio = '../uploads/';
            $rutaImagen = $directorio . basename($imagen);
            if (move_uploaded_file($_FILES['imatge']['tmp_name'], $rutaImagen)) {
                // Imagen subida correctamente, almacenamos la ruta
                $_SESSION['imagen'] = $rutaImagen;
            } else {
                $errores['imatge'] = "Hubo un error al subir la imagen.";
            }
        }
    }
    

    // Si no hay errores, guardar la sesión y redirigir
    if (empty($errores)) {
        $_SESSION['usuario'] = $dades['usuari'];
        $_SESSION['apellidos'] = $dades['cognoms'];
        header("Location: Home.php");  
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Página de registro</title>
    <link rel="stylesheet" href="../CSS/Web.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="login">
    <form class="form" method="post" action="#" enctype="multipart/form-data">
        <p class="title">Registro</p>

        <!-- Nombre, Apellidos, Usuario -->
        <label class="obligatorio">
            <input class="input" type="text" name="nom" value="<?= htmlspecialchars($dades['nom'] ?? '') ?>" placeholder=" ">
            <span>Nombre<span style="color:red;"> (*)</span></span>
        </label>
        <?= !empty($errores['nom']) ? "<p class='error'>{$errores['nom']}</p>" : '' ?>

        <label class="obligatorio">
            <input class="input" type="text" name="cognoms" value="<?= htmlspecialchars($dades['cognoms'] ?? '') ?>" placeholder=" ">
            <span>Apellidos<span style="color:red;"> (*)</span></span>
        </label>
        <?= !empty($errores['cognoms']) ? "<p class='error'>{$errores['cognoms']}</p>" : '' ?>

        <label class="obligatorio">
            <input class="input" type="text" name="usuari" value="<?= htmlspecialchars($dades['usuari'] ?? '') ?>" placeholder=" ">
            <span>Usuario<span style="color:red;"> (*)</span></span>
        </label>
        <?= !empty($errores['usuari']) ? "<p class='error'>{$errores['usuari']}</p>" : '' ?>

             <!-- Contraseña -->
        <label class="obligatorio">
            <input class="input" type="password" name="contrasenya" placeholder=" ">
            <span>Contraseña<span style="color:red;"> (*)</span></span>
        </label>
        <?= !empty($errores['contrasenya']) ? "<p class='error'>{$errores['contrasenya']}</p>" : '' ?>
        
        <!-- Confirmar Contraseña -->
        <label class="obligatorio">
            <input class="input" type="password" name="confirma_contrasenya" placeholder=" ">
            <span>Confirmar contraseña<span style="color:red;"> (*)</span></span>
        </label>
        <?= !empty($errores['confirma_contrasenya']) ? "<p class='error'>{$errores['confirma_contrasenya']}</p>" : '' ?>
        
        <!-- Campo DNI -->
        <label class="obligatorio">
            <input class="input" type="text" name="dni" value="<?= htmlspecialchars($dades['dni'] ?? '') ?>" placeholder="12345678A">
            <span>DNI<span style="color:red;"> (*)</span></span>
        </label>
        <?= !empty($errores['dni']) ? "<p class='error'>{$errores['dni']}</p>" : '' ?>
        
        <!-- Campo Fecha de nacimiento -->
        <label class="obligatorio">
            <input class="input" type="date" name="data_naixement" value="<?= htmlspecialchars($dades['data_naixement'] ?? '') ?>">
            <span>Fecha de nacimiento<span style="color:red;"> (*)</span></span>
        </label>
        <?= !empty($errores['data_naixement']) ? "<p class='error'>{$errores['data_naixement']}</p>" : '' ?>
             
        <!-- Sexo -->
        <label class="obligatorio">
            <span>Sexo</span>
            <select name="sexe">
                <option value="">Selecciona</option>
                <option value="M" <?= (isset($dades['sexe']) && $dades['sexe'] === 'M') ? 'selected' : '' ?>>Masculino</option>
                <option value="F" <?= (isset($dades['sexe']) && $dades['sexe'] === 'F') ? 'selected' : '' ?>>Femenino</option>
            </select>
        </label>
        <?= !empty($errores['sexe']) ? "<p class='error'>{$errores['sexe']}</p>" : '' ?>

        <!-- Código Postal, Población, Teléfono -->
        <label>
            <input class="input" type="text" name="codi_postal" value="<?= htmlspecialchars($dades['codi_postal'] ?? '') ?>" placeholder=" ">
            <span>Código Postal</span>
        </label>
        <?= !empty($errores['codi_postal']) ? "<p class='error'>{$errores['codi_postal']}</p>" : '' ?>

        <label>
            <input class="input" type="text" name="poblacio" value="<?= htmlspecialchars($dades['poblacio'] ?? '') ?>" placeholder=" ">
            <span>Población</span>
        </label>

        <label>
            <input class="input" type="text" name="telefon" value="<?= htmlspecialchars($dades['telefon'] ?? '') ?>" placeholder=" ">
            <span>Teléfono</span>
        </label>
        <?= !empty($errores['telefon']) ? "<p class='error'>{$errores['telefon']}</p>" : '' ?>

        <!-- Imagen -->
        <label class="obligatorio">
            <input type="file" name="imatge" accept="image/*">
            <span>Subir Imagen<span style="color:red;"> (*)</span></span>
        </label>
        <?= !empty($errores['imatge']) ? "<p class='error'>{$errores['imatge']}</p>" : '' ?>

        <!-- Botón -->
        <button class="submit" type="submit">Enviar</button>
        <p class="signin">
            ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
        </p>
        <p class="signin"><a href="Home.php">Regresar al home</a></p>
    </form>
</body>
</html>
