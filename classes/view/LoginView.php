<?php

class LoginView{
    
    public function __construct() {}
    
    public function show() {
        echo '<!DOCTYPE html>
                <html lang="es">
                <head>
                    <meta charset="UTF-8" />
                    <title>Página de Login</title>
                    <link rel="stylesheet" href="../CSS/Web.css" />
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                </head>
                <body class="login">
                    <form class="form" method="post" action="">
                        <p class="title">Login</p>
                            
                        <!-- Nombre -->
                        <label>
                            <input class="input" type="text" name="nom" placeholder="Nombre">
                            <span>Nombre<span style="color:red;"> (*)</span></span>
                        </label>
                            
                        <!-- Apellidos -->
                        <label>
                            <input class="input" type="text" name="cognoms" placeholder="Apellidos">
                            <span>Apellidos<span style="color:red;"> (*)</span></span>
                        </label>
                            
                        <!-- Contraseña -->
                        <label>
                            <input class="input" type="password" name="contrasenya" placeholder="Contraseña">
                            <span>Contraseña<span style="color:red;"> (*)</span></span>
                        </label>
                            
                        <button class="submit" type="submit">Enviar</button>
                            
                        <p class="signin">
                            ¿No tienes cuenta? <a href="?Registro/show">Regístrate</a>
                        </p>
                            
                        <p class="signin"><a href="index.php">Regresar al home</a></p>
                    </form>
                </body>
                </html>';
        
        
    }
    public function form(LoginModel $login){
        
        $name = $login ->__get("nom");
        $lastName = $login ->__get("cognoms");
        $pass= $login ->__get("contrasenya");
        
        $errors = $login ->errors;
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
    <form class="form" method="POST">
        <p class="title">Login</p>

        <!-- Nombre -->
        <label>
            <input class="input" type="text" name="nom" placeholder="Nombre" value="<?= htmlspecialchars($name) ?>">
            <span>Nombre<span style="color:red;"> (*)</span></span>
        </label>
        <?php if (!empty($errors['nom'])): ?>
            <p class="error"><?= $errors['nom'] ?></p>
        <?php endif; ?>

        <!-- Apellidos -->
        <label>
            <input class="input" type="text" name="cognoms" placeholder="Apellidos" value="<?= htmlspecialchars($lastName) ?>">
            <span>Apellidos<span style="color:red;"> (*)</span></span>
        </label>
        <?php if (!empty($errors['cognoms'])): ?>
            <p class="error"><?= $errors['cognoms'] ?></p>
        <?php endif; ?>

        <!-- Contraseña -->
        <label>
            <input class="input" type="password" name="contrasenya" placeholder="Contraseña">
            <span>Contraseña<span style="color:red;"> (*)</span></span>
        </label>
        <?php if (!empty($errors['contrasenya'])): ?>
            <p class="error"><?= $errors['contrasenya'] ?></p>
        <?php endif; ?>
        <button class="submit" type="submit" name="envia">Enviar</button>

        <p class="signin">
            ¿No tienes cuenta? <a href="?Registro/show">Regístrate</a>
        </p>

        <p class="signin"><a href="index.php">Regresar al home</a></p>
    </form>
</body>
</html>
        <?php 
        
    }
}