<?php

class RegistroView {
    
    public function __construct() {}
    
    public function show() {
        echo '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Página de registro</title>
    <link rel="stylesheet" href="../CSS/Web.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="login">
    <form class="form" method="post" action="" enctype="multipart/form-data">
        <p class="title">Registro</p>
            
        <!-- Nombre, Apellidos, Usuario -->
        <label class="obligatorio">
            <input class="input" type="text" name="nom" placeholder=" ">
            <span>Nombre<span style="color:red;"> (*)</span></span>
        </label>
            
        <label class="obligatorio">
            <input class="input" type="text" name="cognoms" placeholder=" ">
            <span>Apellidos<span style="color:red;"> (*)</span></span>
        </label>
            
        <label class="obligatorio">
            <input class="input" type="text" name="usuari" placeholder=" ">
            <span>Usuario<span style="color:red;"> (*)</span></span>
        </label>
            
        <label class="obligatorio">
            <input class="input" type="password" name="contrasenya" placeholder=" ">
            <span>Contraseña<span style="color:red;"> (*)</span></span>
        </label>
            
        <label class="obligatorio">
            <input class="input" type="password" name="confirma_contrasenya" placeholder=" ">
            <span>Confirmar contraseña<span style="color:red;"> (*)</span></span>
        </label>
            
        <label class="obligatorio">
            <input class="input" type="text" name="dni" placeholder="12345678A">
            <span>DNI<span style="color:red;"> (*)</span></span>
        </label>
            
        <label class="obligatorio">
            <input class="input" type="date" name="data_naixement">
            <span>Fecha de nacimiento<span style="color:red;"> (*)</span></span>
        </label>
            
        <label class="obligatorio">
            <span>Sexo</span>
            <select name="sexe">
                <option value="">Selecciona</option>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
            </select>
        </label>
            
        <label>
            <input class="input" type="text" name="codi_postal" placeholder=" ">
            <span>Código Postal</span>
        </label>
            
        <label>
            <input class="input" type="text" name="poblacio" placeholder=" ">
            <span>Población</span>
        </label>
            
        <label>
            <input class="input" type="text" name="telefon" placeholder=" ">
            <span>Teléfono</span>
        </label>
            
        <label class="obligatorio">
            <input type="file" name="imatge" accept="image/*">
            <span>Subir Imagen<span style="color:red;"> (*)</span></span>
        </label>
            
        <button class="submit" type="submit">Enviar</button>
        <p class="signin">
            ¿Ya tienes cuenta? <a href="?login/show">Inicia sesión</a>
        </p>
        <p class="signin"><a href="index.php">Regresar al home</a></p>
    </form>
</body>
</html>';
        
        
    }
    
    public function form(RegistroModel $register)
    {
        $nom                 = $register->__get('nom')                 ?? '';
        $cognoms             = $register->__get('cognoms')             ?? '';
        $usuari              = $register->__get('usuari')              ?? '';
        $contrasenya         = $register->__get('contrasenya')         ?? '';
        $confirma_contrasenya = $register->__get('confirma_contrasenya') ?? '';
        $dni                 = $register->__get('dni')                 ?? '';
        $data_naixement      = $register->__get('data_naixement')      ?? '';
        $sexe                = $register->__get('sexe')                ?? '';
        $codi_postal         = $register->__get('codi_postal')         ?? '';
        $poblacio            = $register->__get('poblacio')            ?? '';
        $telefon             = $register->__get('telefon')             ?? '';
        
        $errors = $register->errors; 
        
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
        <form class="form" method="post" action="" enctype="multipart/form-data">
            <p class="title">Registro</p>

            <!-- Nombre -->
            <label class="obligatorio">
                <input class="input" type="text" name="nom" value="<?= htmlspecialchars($nom); ?>" />
                <span>Nombre<span style="color:red;"> (*)</span></span>
            </label>
            <?= !empty($errors['nom']) ? "<p class='error'>{$errors['nom']}</p>" : '' ?>

            <!-- Apellidos -->
            <label class="obligatorio">
                <input class="input" type="text" name="cognoms" value="<?= htmlspecialchars($cognoms); ?>" placeholder=" ">
                <span>Apellidos<span style="color:red;"> (*)</span></span>
            </label>
            <?= !empty($errors['cognoms']) ? "<p class='error'>{$errors['cognoms']}</p>" : '' ?>

            <!-- Usuario -->
            <label class="obligatorio">
                <input class="input" type="text" name="usuari" value="<?= htmlspecialchars($usuari); ?>" placeholder=" ">
                <span>Usuario<span style="color:red;"> (*)</span></span>
            </label>
            <?= !empty($errors['usuari']) ? "<p class='error'>{$errors['usuari']}</p>" : '' ?>

            <!-- Contraseña -->
            <label class="obligatorio">
                <input class="input" type="password" name="contrasenya" placeholder=" ">
                <span>Contraseña<span style="color:red;"> (*)</span></span>
            </label>
            <?= !empty($errors['contrasenya']) ? "<p class='error'>{$errors['contrasenya']}</p>" : '' ?>

            <!-- Confirmar Contraseña -->
            <label class="obligatorio">
                <input class="input" type="password" name="confirma_contrasenya" placeholder=" ">
                <span>Confirmar contraseña<span style="color:red;"> (*)</span></span>
            </label>
            <?= !empty($errors['confirma_contrasenya']) ? "<p class='error'>{$errors['confirma_contrasenya']}</p>" : '' ?>

            <!-- DNI -->
            <label class="obligatorio">
                <input class="input" type="text" name="dni" value="<?= htmlspecialchars($dni); ?>" placeholder="12345678A">
                <span>DNI<span style="color:red;"> (*)</span></span>
            </label>
            <?= !empty($errors['dni']) ? "<p class='error'>{$errors['dni']}</p>" : '' ?>

            <!-- Fecha de nacimiento -->
            <label class="obligatorio">
                <input class="input" type="date" name="data_naixement" value="<?= htmlspecialchars($data_naixement); ?>">
                <span>Fecha de nacimiento<span style="color:red;"> (*)</span></span>
            </label>
            <?= !empty($errors['data_naixement']) ? "<p class='error'>{$errors['data_naixement']}</p>" : '' ?>

            <label class="obligatorio">
                <span>Sexo</span>
                <select name="sexe">
                    <option value="M" <?= ($sexe === 'M') ? 'selected' : '' ?>>Masculino</option>
                    <option value="F" <?= ($sexe === 'F') ? 'selected' : '' ?>>Femenino</option>
                </select>
            </label>
            <?= !empty($errors['sexe']) ? "<p class='error'>{$errors['sexe']}</p>" : '' ?>
            
            <label>
                <input class="input" type="text" name="codi_postal" value="<?= htmlspecialchars($codi_postal); ?>" placeholder=" ">
                <span>Código Postal</span>
            </label>
            <?= !empty($errors['codi_postal']) ? "<p class='error'>{$errors['codi_postal']}</p>" : '' ?>

            <label>
                <input class="input" type="text" name="poblacio" value="<?= htmlspecialchars($poblacio); ?>" placeholder=" ">
                <span>Población</span>
            </label>

            <label>
                <input class="input" type="text" name="telefon" value="<?= htmlspecialchars($telefon); ?>" placeholder=" ">
                <span>Teléfono</span>
            </label>
            <?= !empty($errors['telefon']) ? "<p class='error'>{$errors['telefon']}</p>" : '' ?>

            <label class="obligatorio">
                <input type="file" name="imatge" accept="image/*">
                <span>Subir Imagen<span style="color:red;"> (*)</span></span>
            </label>
            <?= !empty($errors['imatge']) ? "<p class='error'>{$errors['imatge']}</p>" : '' ?>

            <button class="submit" type="submit" name="envia">Enviar</button>
            <p class="signin">
                ¿Ya tienes cuenta? <a href="?login/show">Inicia sesión</a>
            </p>
            <p class="signin"><a href="index.php">Regresar al home</a></p>
        </form>
    </body>
    </html>
    
    <?php
    }
}
