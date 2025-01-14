<?php

class AdminUser extends DBAbstractModel{
    
    protected $id;
    public $name;
    public $lastName;
    public $userName;
    private $password;
    public $dni;
    public $phoneNumber;
    
    function __construct(){
        parent::$db_user = 'usr_generic';
        parent::$db_pass = '2025@Thos';
    }
    
    public function set($data=array()){
        if (!empty($data)) {
            $this->query = "
                INSERT INTO usuarios (nombre, apellidos, nombre_de_usuario, contraseña, dni, numero_de_telefono)
                VALUES (
                    '{$data['name']}',
                    '{$data['lastName']}',
                    '{$data['userName']}',
                    '{$data['password']}',
                    '{$data['dni']}',
                    '{$data['phoneNumber']}'
                )
            ";
            $this->execute_single_query();
        }
    }

    public function edit($data=array()){
        foreach ($data as $clave => $valor){
            $$clave=$valor;
            $this->query="UPDATE usuarios SET nombre='$name', apellidos='$lastName',
            nombre_de_usuario='$userName', contraseña='$password',
            dni='$dni',numero_de_telefono='$phoneNumber'
            WHERE nombre_de_usuario='$userName'";
        }
    }

    public function get()
    {
       
    }

    public function delete($userName=''){
       
            $this->query = "
                DELETE FROM usuarios
                WHERE nombre_de_usuario = '$userName'
            ";
            $this->execute_single_query();
        
    }

    
    
}