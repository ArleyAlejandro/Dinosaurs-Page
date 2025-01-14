<?php

class LoginController {
    
    public function __construct() {}
    
    public function show($params=null) {
        $vlogin = new LoginView();
        $vlogin->show();
        
    }
    
    public function form($params){
        
            $name = $lastName = $pass = '';
            
        // Validar que los campos no estén vacíos
        if (empty($params["nom"])) {
            $errors['nom'] = "El campo de nombre es obligatorio.";
        }else{
            $name = strtolower($params["nom"]);
        }
        
        if (empty($params["cognoms"])) {
            $errors['cognoms'] = "El campo de apellidos es obligatorio.";
        }else{
            $lastName = strtolower($params["cognoms"]);
        }
        
        if (empty($params["contrasenya"])) {
            $errors['contrasenya'] = "El campo de contraseña es obligatorio.";
        } elseif (!validarContrasena($params["contrasenya"])) {
            $errors['contrasenya'] = "La contraseña debe tener al menos 8 caracteres, incluir mayúsculas, minúsculas, números y caracteres especiales.";
        }else{
            $pass = $params["contrasenya"];
        }
        
            $login = new LoginModel($name, $lastName, $pass);
            
        if (!empty($errors)) {
            $login->errors=$errors;
        }
            $vlogin = new LoginView();
            $vlogin->form($login);
    }
}