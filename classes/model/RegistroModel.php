<?php

class RegistroModel{
    
    private $nom;
    private $cognoms;
    private $usuari;
    private $contrasenya;
    private $confirma_contrasenya;
    private $dni;
    private $data_naixement;
    private $sexe;
    private $codi_postal;
    private $poblacio;
    private $telefon;
    public $errors = []; 
    
    public function __construct() {}
    
    public function __get($prop) {
        if (property_exists($this, $prop)) {
            return $this->$prop;
        }
    }
    public function __set($prop, $value) {
        if (property_exists($this, $prop)) {
            $this->$prop = $value;
        }
    }
}