<?php

class Potatoe {
    
    private static $_instance;
    
    private $host;
    private $db_name;
    private $port;
    
    private function __construct(){
        $filename = __ROOT__ . "config/config.xml";
        if (file_exists($filename)) {
            if ($fitxer = simplexml_load_file($filename)) {
                $this->host = $fitxer->base_de_dades->host->__toString();
                $this->db_name = $fitxer->base_de_dades->db_name->__toString();
                $this->port = $fitxer->base_de_dades->port->__toString();
            } else {
                throw new Exception("Fitxer de configuració amb mal format");
            }
        } else {
            throw new Exception("No s'ha pogut obrir el fitxer de configuració");
        }
    }
    
    public function getHost()     { return $this->host; }
    public function getDbName()   { return $this->db_name; }
    public function getPort()     { return $this->port; }
    
    public static function getInstance(){
        if (is_null(self::$_instance)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    private function __clone() {}
}