<?php
class LoginModel{
    private $email;
    private $pass;
    public $errors;
    
    public function __construct( $email, $pass) {
        $this->email = $email;
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