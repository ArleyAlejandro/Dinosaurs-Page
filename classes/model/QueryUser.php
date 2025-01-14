<?php

class QueryUser extends DBAbstractModel {
    
    protected $id;
    public $name;
    public $lastName;
    public $userName;
    private $password;
    public $dni;
    public $phoneNumber;
        
    
    function __construct(){
        parent::$db_user = 'usr_consulta';
        parent::$db_pass = '2025@Thos';
    }
    
    public function get($userName ='') 
    {
        $this->query="
            SELECT id, nombre, apellidos, nombre_de_usuario, contraseña,
            dni, numero_de_telefono FROM usuarios WHERE nombre_de_usuario = '$userName'
                    ";
        $this->get_results_from_query();
        
        
        if (count($this->rows) == 1) {
            foreach ($this->rows[0] as $prop => $value) {
                $this->$prop = $value;
            }
            return true;
        }
    }
    
    protected function set()
    {}
    
    protected function edit()
    {}
    
    protected function delete()
    {}
}