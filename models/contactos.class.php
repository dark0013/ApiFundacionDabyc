<?php
require_once "../config/conexion/conexion.php";
require_once "../config/respuesta.class.php";
require_once "../config/Logs.php";

class Contactos extends conexion
{
    private $tabla = "tbl_contactos";
    private $id_contacto = "";
    private $indentication_card = "";
    private $full_name = "";
    private $phone = "";
    private $email = "";
    private $address = "";
    private $description = "";
    private $status = "";
    private $user_sesion = "";
    private $date_creation = "";
    private $usur_creation = "";
    private $user_update = "";

    public function listarContactos($pagina = 1)
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


    public function obtenerIdContactos($id)
    {
        $query = "select * from $this->tabla where id_user  = $id";
        return $datos = parent::obtenerDatos($query);
    }

    /* POST */


    public function post($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        if (!isset($datos["indentication_card"]) || !isset($datos["full_name"])) {
            return $_respuestas->error_400();
        } else {
            $this->indentication_card = $datos['indentication_card'];
            $this->full_name = $datos['full_name'];
            $this->phone = $datos['phone'];
            $this->email = $datos['email'];
            $this->address = $datos['address'];
            $this->description = $datos['description'];
            $this->status = $datos['status'];
            $this->user_sesion = $datos['user_sesion'];
            $this->date_creation = $datos['date_creation'];
            $this->usur_creation = $datos['usur_creation'];

            $resp = $this->insertarContactos();

            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "ContactosId" => $resp
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }


    private function insertarContactos()
    {
        $query = "INSERT INTO $this->tabla(indentication_card, full_name, phone, email, address, description, status, user_sesion, date_creation, usur_creation)
         VALUES ('$this->indentication_card', '$this->full_name','$this->phone','$this->email','$this->address','$this->description','$this->status','$this->user_sesion','$this->date_creation','$this->usur_creation')";
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
        if (!isset($datos["indentication_card"]) || !isset($datos["full_name"])) {
            return $_respuestas->error_400();
        } else {
            $this->id_contacto = $datos['id_contacto'];
            $this->indentication_card = $datos['indentication_card'];
            $this->full_name = $datos['full_name'];
            $this->phone = $datos['phone'];
            $this->email = $datos['email'];
            $this->address = $datos['address'];
            $this->description = $datos['description'];
            $this->status = $datos['status'];
            $this->user_sesion = $datos['user_sesion'];
            $this->date_creation = $datos['date_creation'];
            $this->usur_creation = $datos['usur_creation'];
            $this->user_update = $datos['user_update'];
            
            $resp = $this->actualizarContactos();

            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_contacto" => $resp
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }


    private function actualizarContactos()
    {
        $query = "UPDATE `tbl_contactos` SET `indentication_card`='$this->indentication_card', `full_name`='$this->full_name', `phone`='$this->phone', `email`='$this->email',
        `address`='$this->address',`description`='$this->description',`status`='$this->status',`user_sesion`='$this->user_sesion', `date_creation`='$this->date_creation',
        `usur_creation`='$this->usur_creation',`user_update`='$this->user_update' WHERE `id_contacto` = '$this->id_contacto'";
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

        if (!isset($datos["id_contacto"])) {
            return $_respuestas->error_400();
        } else {

            $this->id_contacto = $datos['id_contacto'];

            $resp = $this->eliminarContactos();

            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_contacto" => $this->id_contacto
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }




    private function eliminarContactos()
    {
        $query = "DELETE FROM $this->tabla WHERE id_contacto='$this->id_contacto'";

        $resp = parent::noQuery($query);

        if ($resp >= 1) {
            return $resp;
        } else {
            return 0;
        }
    }
}

