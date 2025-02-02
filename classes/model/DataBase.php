<?php

class DataBase
{
    
    private static $_instance;
    private $query;
    protected $eventData;
    protected $rows = array();
    private $conn;
    private $configuration;
    
    private function __construct()
    {
        $this->configuration = Config::getInstance();
        $this->conn = new mysqli(
            $this->configuration->getHost(),
            $this->configuration->getName(),
            $this->configuration->getPass(),
            $this->configuration->getDbName(),
            $this->configuration->getPort()
            );
        
    }
    
    public function __get($prop)
    {
        if (property_exists($this, $prop)) {
            return $this->$prop;
        }
    }
    
    public function __set($prop, $val)
    {
        if (property_exists($this, $prop)) {
            $this->$prop = $val;
        }
    }
    
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    public function executeQuery($query, $types = null, $params = [])
    {
        if (empty($query)) {
            echo "Query is empty!";
            return [];
        }
        
        $rows = [];
        
        $stmt = $this->conn->prepare($query);
        if (! $stmt) {
            echo "Error preparing query: " . $this->conn->error;
            return $rows;
        }
        
        if ($types && ! empty($params)) {
            $stmt->bind_param($types, ...$params);
            
            $success = $stmt->execute();
            
            return $success;
        } else {
            
            $stmt->execute();
            
            $result = $stmt->get_result();
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }
                $result->free();
            }
            $stmt->close();
            
            return $rows;
        }
    }
    
    public function close_connection()
    {
        $this->conn->close();
    }
    
    private function __clone()
    {}
}