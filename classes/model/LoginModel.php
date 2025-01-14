<?php
class LoginModel{
    private $name;
    private $lastName;
    private $pass;
    public $errors;
    
    public function __construct($name, $lastName, $pass) {
        $this->name = $name;
        $this->lastName = $lastName;
        $this->pass = $pass;
    }
    
    
    public function __get($prop) {
        if (property_exists($this, $prop)) {
            return $this->$prop;
        }
    }
    
    public function __set($prop, $val) {
        if (property_exists($this, $prop)) {
            $this->$prop = $val;
        }
    }
}