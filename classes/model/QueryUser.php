<?php

class QueryUser extends DBAbstractModel {
    public $nombre;
    public $apellidos;
    public $email;
   public  function __construct(){
        parent::$db_user = 'usr_consulta';
        parent::$db_pass = '2025@Thos';
    }
    
    public function get($user_email ='') 
    {
        $this->query = "SELECT * FROM usuarios WHERE email = '$user_email'";
        $this->get_results_from_query();
        
        if (count($this->rows) == 1) {
            foreach ($this->rows[0] as $prop => $value) {
                $this->$prop = $value;
            }
            return true;
        }
        
        return null;
    }
    
    public function emailExists($email)
    {
        $this->query = "SELECT COUNT(*) as count FROM usuarios WHERE email = '$email'";
        $this->get_results_from_query();

        // Retorna verdadero si el email existe, de lo contrario, falso
        return $this->rows[0]['count'] > 0;
    }
    
    protected function set()
    {}
    
    protected function edit()
    {}
    
    protected function delete()
    {}
}