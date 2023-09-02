<?php

require_once "../config/conexion/conexion.php";
require_once "../config/respuesta.class.php";
require_once "../config/Logs.php";


class Passwords extends conexion
{
    private $tabla = "passwords";
    private $idpasswords  = "";
    private $iduser  = "";
    private $namepassword = "";
    private $password  = "";
    private $activo  = "";
    private $delete  = "";
    private $date_registro  = "";

    /*  Mostrar   */
    public function listarPasswords($pagina = 1)
    {
        $inicio = 0;
        $cantidad = 100;

        if ($pagina > 1) {
            $inicio = $cantidad * ($pagina - 1) + 1;
            $cantidad = $cantidad * $pagina;
        }

        $query = "SELECT * FROM {$this->tabla} WHERE activo = 'A' LIMIT $inicio, $cantidad";

        //print_r($query);
        $datos = parent::obtenerDatos($query);
        return $datos;
    }
    /*
    public function callProcedure($pagina = 1)
    {
        $query = "CALL PRC_PRUEBA(@p0, @p1);";
        $datos = parent::callProcedure($query);
        return $datos;
    }

*/

    public function obtenerPasswords($iduser)
    {
        $query = "SELECT u.*, p.* FROM users u JOIN passwords p ON u.iduser = p.iduser WHERE p.delete = '0' AND u.activo = 'A' AND p.iduser = $iduser";
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    public function CountPasswords($id)
    {
        $query = "SELECT COUNT(*) as totalPasswords FROM $this->tabla where activo = 'A'";
        return $datos = parent::obtenerDatos($query);
    }


    /* POST */
    public function post($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        if (!isset($datos["iduser"]) || !isset($datos["namepassword"])|| !isset($datos["activo"])|| !isset($datos["delete"]) || !isset($datos["date_registro"])){
           
            return $_respuestas->error_400();
        } else {
            $this->iduser = $datos['iduser'];
            $this->namepassword = $datos['namepassword'];
            $this->password = $datos['password'];
            $this->activo = $datos['activo'];
            $this->delete = $datos['delete'];
            $this->date_registro = $datos['date_registro'];

            $resp = $this->insertarPasswords();

            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "PasswordsId" => $resp
                );


                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    private function insertarPasswords()
    {
        $query = "INSERT INTO `passwords`(iduser,`namepassword`, `password`, activo, `delete`, date_registro) 
        VALUES ('$this->iduser','$this->namepassword', '$this->password','$this->activo', '$this->delete', '$this->date_registro')";
       
        $resp = parent::noQueryId($query);

        if ($resp) {
            return $resp ;
        } else {
            return 0;
        }
    }



    /* PUT */

    public function put($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        if (!isset($datos["namepassword"])|| !isset($datos["activo"])|| !isset($datos["delete"]) || !isset($datos["date_update"])){
            return $_respuestas->error_400();
        } else {
            
            $this->idpasswords = $datos['idpasswords'];
            $this->namepassword = $datos['namepassword'];
            $this->password = $datos['password'];
            $this->activo = $datos['activo'];
            $this->delete = $datos['delete'];
            $this->date_update = $datos['date_update'];

            $resp = $this->modificarPasswords();

            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "PasswordsId" => $resp
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    private function modificarPasswords()
    {
        $query = "UPDATE `passwords` SET `namepassword` ='$this->namepassword', `password`='$this->password', `activo`='$this->activo', 
        `delete`='$this->delete', `date_update`='$this->date_update' WHERE `idpasswords` = '$this->idpasswords'";

        //print_r($query);
        $resp = parent::noQuery($query);

        if ($resp) {
            return $resp;
        } else {
            return 0;
        }
    }


    /* DELETE */


    public function delete($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        if (!isset($datos["idpasswords"])|| !isset($datos["date_delete"])){
            return $_respuestas->error_400();
        } else {
            
            $this->idpasswords = $datos['idpasswords'];
            $this->date_delete = $datos['date_delete'];

            $resp = $this->deletePasswords();

            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "PasswordsId" => $resp
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    private function deletePasswords()
    {
        $query = "UPDATE `passwords` SET `activo`='I',`delete`='1', `date_delete`='$this->date_delete' WHERE `idpasswords` = '$this->idpasswords'";

        //print_r($query);
        $resp = parent::noQuery($query);

        if ($resp) {
            return $resp;
        } else {
            return 0;
        }
    }
}
