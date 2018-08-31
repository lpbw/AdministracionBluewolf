<?php

/**
 * CONF short summary.
 *
 * CONF description.
 *
 * @version 1.0
 * @author isaac.ojeda
 */
class DatabaseConfig
{
    private $host="localhost";
    private $user="bluewol5_tienda";
    private $password="Mytienda11!";
    private $database_name="bluewol5_tienda";
    private $conn;

    function __construct(){
        $this->conn = new mysqli($this->host, $this->user,$this->password,$this->database_name);
        if($this->conn->connect_error){
            die("Connection failed:" . $this->conn->connect_error);
        }
    }

    /**
     * Ejecuta cualquier consulta SQL al servidor
     * @param mixed $query Consulta SQL a ejecutar
     * @return mixed 
     */
    public function execute_sql($query)
    {        
        $result = $this->conn->query($query)
            or die("Error ejecutando la consulta:" . $query);
        
        return $result;
    }
    /**
     * Summary of close
     */
    public function close(){
        $this->conn->close();
    }
}

?>