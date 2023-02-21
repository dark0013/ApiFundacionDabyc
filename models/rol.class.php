<?php
require_once "../config/conexion/conexion.php";
require_once "../config/respuesta.class.php";
require_once "../config/Logs.php";

class Roles extends conexion
{

    private $tabla = "tbl_roles";
    private $id_rol = "";
    private $rol_user = "";
    private $status = "";
    private $user_sesion = "";
    private $date_creation = "";
    private $usur_creation = "";
    private $user_upda = "";
    public function listarRoles($pagina = 1)
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


    public function obtenerRoles($id)
    {
        $query = "select * from $this->tabla where id_user  = $id";
        return $datos = parent::obtenerDatos($query);
    }


    /* POST */


    public function post($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        if (!isset($datos["rol_user"]) || !isset($datos["user_sesion"])) {
            return $_respuestas->error_400();
        } else {
            $this->rol_user = $datos['rol_user'];
            $this->user_sesion = $datos['user_sesion'];
            $this->date_creation = $datos['date_creation'];
            $this->usur_creation = $datos['usur_creation'];


            $resp = $this->insertarRol();

            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_rol" => $resp
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }


    private function insertarRol()
    {
        $query = "INSERT INTO $this->tabla(id_rol, rol_user,  user_sesion, date_creation, usur_creation) VALUES ('$this->id_rol', '$this->rol_user', '$this->user_sesion', '$this->date_creation', '$this->usur_creation')";
        $resp = parent::noQueryId($query);

        if ($resp) {
            return $resp;
        } else {
            return 0;
        }
    }



    /* PuT */


    public function put($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        if (!isset($datos["rol_user"]) || !isset($datos["user_sesion"])) {
            return $_respuestas->error_400();
        } else {
            $this->id_rol = $datos['id_rol'];
            $this->rol_user = $datos['rol_user'];

            $this->user_sesion = $datos['user_sesion'];
            $this->date_creation = $datos['date_creation'];
            $this->usur_creation = $datos['usur_creation'];


            $resp = $this->actualizarRol();

            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_rol" => $resp
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    
    private function actualizarRol()
    {
        $query = "";
       // $query = "INSERT INTO $this->tabla(id_rol, rol_user,  user_sesion, date_creation, usur_creation) VALUES ('$this->id_rol', '$this->rol_user', '$this->user_sesion', '$this->date_creation', '$this->usur_creation')";
        $resp = parent::noQueryId($query);

        if ($resp) {
            return $resp;
        } else {
            return 0;
        }
    }
}
