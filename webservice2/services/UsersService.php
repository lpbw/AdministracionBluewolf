<?php
include_once "../helpers/DatabaseConfig.php";
include_once "../models/UserModel.php";

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
     * Autentica un usuario y contrase�a
     * @param mixed $user
     * @param mixed $password
     * @return UserModel Resultado de la autenticaci�n
     */
    public function authenticateUser($latitud,$longitud)
    {
        $query = "UPDATE usuariospruebas SET latitud='$latitud',longitud='$longitud' WHERE id_usuario=1";
        $result = $this->conf->execute_sql($query);
        $query = "SELECT id_usuario,latitud,longitud FROM usuariospruebas WHERE id_usuario=2";//WHERE email = '$user' and password = '$password'
        $result = $this->conf->execute_sql($query);
        
		//echo $result->num_rows;
        //if ($result->num_rows > 0){
		$user[] = new UserModel();
		$count=0;
         while($row = $result->fetch_assoc()){
			//$row = $result->fetch_assoc();
            
			$user[$count]->id_usuario = $row["id_usuario"];
            $user[$count]->latitud = $row["latitud"];
            $user[$count]->longitud = $row["longitud"];
			
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