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
                            
                        <!-- Email -->
                        <label>
                            <input class="input" type="text" name="email" placeholder="Correo">
                            <span>Email<span style="color:red;"> (*)</span></span>
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
        
        $email = $login ->__get("email");
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
    
        <!-- Email -->
        <label>
            <input class="input" type="text" name="email" placeholder="Correo" value="<?= htmlspecialchars($login->__get('email')) ?>">
            <span>Email<span style="color:red;"> (*)</span></span>
        </label>

        <?php if (!empty($errors['email'])): ?>
            <p class="error"><?= $errors['email'] ?></p>
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