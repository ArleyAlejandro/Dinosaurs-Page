<?php

class AdminUser extends DBAbstractModel
{
    //NOTA
    // los nombres de las propiedades deben ser iguales a los nombres de las columnas de la tabla en la bd, o la asignacion 
    // de valores en el metodo get no funcionara
    
    public $id;
    public $nombre;
    public $apellidos;
    public $email;
    public $contraseña;
    public $tipoID;
    public $numero_identidad;
    public $fech_nacimiento;
    public $sexo;
    public $direccion;
    public $provincia;
    public $codigo_postal;
    public $poblacion;
    public $numero_de_telefono;
    public $ruta_img;
    
    public function __construct()
    {
        parent::$db_user = 'usr_generic';
        parent::$db_pass = '2025@Thos';
    }

    public function get($user_email = '') 
    {
        $this->query = "SELECT * FROM usuarios WHERE email = '$user_email'";
        $this->get_results_from_query();
        
        if (count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad => $valor) {
                    $this->$propiedad = $valor;
            }
            return true;
        }
        
        return null; 
    }
    
    public function set($data = [])
    {
        if (! empty($data)) {
            $this->query = "
                INSERT INTO usuarios (nombre, apellidos, nombre_de_usuario, email, contraseña, tipoID,
numero_identidad,fecha_nacimiento, sexo,direccion, provincia, codigo_postal, poblacion, numero_de_telefono, ruta_img)
                VALUES (
                  " . (empty($data['name']) ? "NULL" : "'{$data['name']}'") . ",
                " . (empty($data['lastName']) ? "NULL" : "'{$data['lastName']}'") . ",
                " . (empty($data['userName']) ? "NULL" : "'{$data['userName']}'") . ",
                " . (empty($data['email']) ? "NULL" : "'{$data['email']}'") . ",
                " . (empty($data['pass']) ? "NULL" : "'{$data['pass']}'") . ",
                " . (empty($data['typeID']) ? "NULL" : "'{$data['typeID']}'") . ",
                " . (empty($data['num_id']) ? "NULL" : "'{$data['num_id']}'") . ",
                " . (empty($data['birthdate']) ? "NULL" : "'{$data['birthdate']}'") . ",
                " . (empty($data['gender']) ? "NULL" : "'{$data['gender']}'") . ",
                " . (empty($data['address']) ? "NULL" : "'{$data['address']}'") . ",
                " . (empty($data['province']) ? "NULL" : "'{$data['province']}'") . ",
                " . (empty($data['postal']) ? "NULL" : "'{$data['postal']}'") . ",
                " . (empty($data['poblation']) ? "NULL" : "'{$data['poblation']}'") . ",
                " . (empty($data['phone']) ? "NULL" : "'{$data['phone']}'") . ",
                " . (empty($data['image']) ? "NULL" : "'{$data['image']}'") . "
                )
            ";
            $this->execute_single_query();
        }
    }

    public function edit($data = [])
    {
        // Verificar que el email esté presente en los datos
        if (array_key_exists('email', $data)) {
            $this->get($data['email']);  
           
                foreach ($data as $clave => $valor) {
                    $$clave = $valor;
                }

                $this->query = "
                    UPDATE usuarios 
                    SET estado='1' 
                    WHERE email='$email'";  
                $this->execute_single_query();
            
        }
    }
    

    public function delete($userName = '')
    {

        $this->query = "
                DELETE FROM usuarios
                WHERE nombre_de_usuario = '$userName'
            ";
        $this->execute_single_query();

    }

}
