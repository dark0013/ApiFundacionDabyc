<?php

require_once "../config/conexion/conexion.php";
require_once "../config/respuesta.class.php";
require_once "../config/Logs.php";


class Usuario extends conexion
{
    private $tabla = "tbl_usuario";
    private $id_user  = "";
    private $name_users  = "";
    private $id_rol = "";
    private $identification_card  = "";
    private $name  = "";
    private $pass  = "";
    private $user_sesion  = "";
    private $usur_creation  = "";
    private $user_update  = "";
    private $status  = "";

    /*  Mostrar   */

    public function listarUsuario($pagina = 1)
    {
        $inicio = 0;
        $cantidad = 100;

        if ($pagina > 1) {
            $inicio = $cantidad * ($pagina - 1) + 1;
            $cantidad = $cantidad * $pagina;
        }

        $query = "select * from $this->tabla limit $inicio,$cantidad";
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

    public function obtenerUsuario($id)
    {
        $query = "select * from $this->tabla where id_user  = $id";
        return $datos = parent::obtenerDatos($query);
    }

    public function CountUsuario($id)
    {
        $query = "SELECT COUNT(*) as totalUser FROM $this->tabla where status = 'S'";
        return $datos = parent::obtenerDatos($query);
    }




    /* POST */


    public function post($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        if (!isset($datos["name"]) || !isset($datos["id_rol"])) {
            return $_respuestas->error_400();
        } else {
            $this->name_users = $datos['name_users'];
            $this->id_rol = $datos['id_rol'];
            $this->identification_card = $datos['identification_card'];
            $this->name = $datos['name'];
            $this->pass = $datos['pass'];
            $this->user_sesion = $datos['user_sesion'];
            $this->usur_creation = $datos['usur_creation'];


            $resp = $this->insertarUsuario();

            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "UsuarioId" => $resp
                );


                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }



    private function insertarUsuario()
    {
        $query = "INSERT INTO `tbl_usuario`(name_users,id_rol, identification_card, name, pass, user_sesion, usur_creation) 
        VALUES ('$this->name_users','$this->id_rol', '$this->identification_card','$this->name', '$this->pass', '$this->user_sesion', '$this->usur_creation')";
        //print_r($query);
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
        if (!isset($datos["name"]) || !isset($datos["id_rol"])) {
            return $_respuestas->error_400();
        } else {
            
            $this->id_user = $datos['id_user'];
            $this->name_users = $datos['name_users'];
            $this->id_rol = $datos['id_rol'];
            $this->identification_card = $datos['identification_card'];
            $this->name = $datos['name'];
            $this->pass = $datos['pass'];
            $this->user_sesion = $datos['user_sesion'];
            $this->usur_creation = $datos['usur_creation'];


            $resp = $this->modificarUsuario();

            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "UsuarioId" => $resp
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }




    private function modificarUsuario()
    {
        $query = "UPDATE `tbl_usuario` SET 'name_users' ='$this->name_users', id_rol='$this->id_rol', identification_card='$this->identification_card', name='$this->name', pass='$this->pass',
        status ='$this->status', user_sesion='$this->user_sesion', user_update='$this->user_update' WHERE     id_user = '$this->id_user'";

        // print_r($query);
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

        if (!isset($datos["id_user"])) {
            return $_respuestas->error_400();
        } else {

            $this->id_user = $datos['id_user'];

            $resp = $this->eliminarUsuario();

            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_user" => $this->id_user
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }




    private function eliminarUsuario()
    {
        $query = "DELETE FROM $this->tabla WHERE id_user='$this->id_user'";

        $resp = parent::noQuery($query);

        if ($resp >= 1) {
            return $resp;
        } else {
            return 0;
        }
    }
}
