<?php

include_once "../helpers/DatabaseConfig.php";
include_once "../models/UserModel.php";

/**
 *
 * @version 1.0
 * @author isaac.ojeda
 */
class UsersService
{
    private $conf;

    /**
     * Summary of __construct
     */
    function __construct(){
        $this->conf = new DatabaseConfig();
    }

    /**
     * Autentica un usuario y contraseña
     * @param mixed $user
     * @param mixed $password
     * @return UserModel Resultado de la autenticación
     */
    public function authenticateUser()
    {
        //$hashedPassword = md5($password);
        
        $query = "SELECT id, nombre, email, password, tipo FROM usuarios";//WHERE email = '$user' and password = '$password'
        $result = $this->conf->execute_sql($query);
        
		//echo $result->num_rows;
        //if ($result->num_rows > 0){
		$user[] = new UserModel();
		$count=0;
         while($row = $result->fetch_assoc()){
			//$row = $result->fetch_assoc();
            
			$user[$count]->id = $row["id"];
            $user[$count]->nombre = $row["nombre"];
            $user[$count]->email = $row["email"];
			$user[$count]->password = $row["password"];
            $user[$count]->tipo = $row["tipo"];
       	//echo $count;
		$count++;
	    }

        return $user;
    }
    /**
     * Summary of close
     */
    public function close(){
        $this->conf->close();
    }
}

?>