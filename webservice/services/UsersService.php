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
    public function usuarios($user,$password)
    {
        //$hashedPassword = md5($password);
			
		$hashedPassword = sha1($password);
      

        $query = "SELECT *
                  FROM usuarios
				  where correo='$user' and password='$hashedPassword'";

        $result = $this->conf->execute_sql($query);

        $user = new UserModel();

        if ($result->num_rows > 0){
            $row = $result->fetch_assoc();

            $user->id_usuarios = $row["id_usuarios"];
            $user->id_sucursal = $row["id_sucursal"];
            $user->id_tipo_usuario = $row["id_tipo_usuario"];
            $user->correo = $row["correo"];
			 $user->password = $row["password"];
            $user->nombre = $row["nombre"];
            $user->direccion = $row["direccion"];
            $user->telefono = $row["telefono"];
			 $user->id_alta_usuarios = $row["id_alta_usuarios"];
            $user->fecha = $row["fecha"];
      
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