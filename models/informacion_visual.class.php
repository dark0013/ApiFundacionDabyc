<?php
require_once "../config/conexion/conexion.php";
require_once "../config/respuesta.class.php";
require_once "../config/Logs.php";

class Informacion_visual extends conexion
{
    private $tabla = "tbl_informacion_visual";
    private $id_information = "";
    private $local_storage = "";
    private $rol_user = "";
    private $status = "";

    public function listarInformacion_visual($pagina = 1)
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


    public function obtenerInformacion_visual($id)
    {
        $query = "select * from $this->tabla where id_user  = $id";
        return $datos = parent::obtenerDatos($query);
    }

    /* POST */


    public function post($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        if (!isset($datos["id_information"]) || !isset($datos["local_storage"])) {
            return $_respuestas->error_400();
        } else {
            $this->id_information = $datos['id_information'];
            $this->local_storage = $datos['local_storage'];
            $this->rol_user = $datos['rol_user'];
            $this->status = $datos['status'];

            $resp = $this->insertarInformacion_visual();

            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "Informacion_visualId" => $resp
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }


    private function insertarInformacion_visual()
    {
        $query = "INSERT INTO $this->tabla(id_information, local_storage, rol_user, status)
         VALUES ('$this->id_information', '$this->local_storage', '$this->rol_user','$this->status')";
        $resp = parent::noQueryId($query);

        if ($resp) {
            return $resp;
        } else {
            return 0;
        }
    }

    /* PuT 

    public function put($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        if (!isset($datos["id_information"]) || !isset($datos["local_storage"])) {
            return $_respuestas->error_400();
        } else {
            $this->id_information = $datos['id_information'];
            $this->local_storage = $datos['local_storage'];
            $this->rol_user = $datos['quantity'];
            $this->status = $datos['status'];

            $resp = $this->actualizarInformacion_visual();

            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_information" => $resp
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }


    private function actualizarInformacion_visual()
    {
        $query = "UPDATE `tbl_informacion_visual` SET `local_storage`='$this->local_storage', `rol_user`='$this->rol_user', `status`='$this->status' WHERE `id_information` = '$this->id_information'";
        print_r($query);
        $resp = parent::noQuery($query);
        if ($resp) {
            return $resp;
        } else {
            return 0;
        }
    }


    /* DELETE 


    public function delete($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if (!isset($datos["id_information"])) {
            return $_respuestas->error_400();
        } else {

            $this->id_information = $datos['id_information'];

            $resp = $this->eliminarInformacion_visual();

            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_information" => $this->id_information
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }




    private function eliminarInformacion_visual()
    {
        $query = "DELETE FROM $this->tabla WHERE id_information='$this->id_information'";

        $resp = parent::noQuery($query);

        if ($resp >= 1) {
            return $resp;
        } else {
            return 0;
        }
    }*/
}
