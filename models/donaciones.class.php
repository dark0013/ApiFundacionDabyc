<?php
require_once "../config/conexion/conexion.php";
require_once "../config/respuesta.class.php";
require_once "../config/Logs.php";

class Donaciones extends conexion
{
    private $tabla = "tbl_donaciones";
    private $id_donacion = "";
    private $type_products = "";
    private $quantity = "";
    private $description = "";
    private $status = "";
    private $date_creation = "";

    public function listarDonaciones($pagina = 1)
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

    /*public function callProcedure($pagina = 1)
    {
        $query = "CALL PRC_PRUEBA(@p0, @p1);";
        $datos = parent::callProcedure($query);
        return $datos;
    }*/


    public function obtenerIDonaciones($id)
    {
        $query = "select * from $this->tabla where id_user  = $id";
        return $datos = parent::obtenerDatos($query);
    }

    /* POST */


    public function post($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        if (!isset($datos["type_products"]) || !isset($datos["quantity"])) {
            return $_respuestas->error_400();
        } else {
            $this->type_products = $datos['type_products'];
            $this->quantity = $datos['quantity'];
            $this->description = $datos['description'];
            $this->status = $datos['status'];
            $this->date_creation = $datos['date_creation'];

            $resp = $this->insertarDonaciones();

            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "DonacionesId" => $resp
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }


    private function insertarDonaciones()
    {
        $query = "INSERT INTO $this->tabla(type_products, quantity, description,status,date_creation)
         VALUES ('$this->type_products', '$this->quantity','$this->description','$this->status','$this->date_creation')";
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
        if (!isset($datos["id_donacion"]) || !isset($datos["type_products"])) {
            return $_respuestas->error_400();
        } else {
            $this->id_donacion = $datos['id_donacion'];
            $this->type_products = $datos['type_products'];
            $this->quantity = $datos['quantity'];
            $this->description = $datos['description'];
            $this->status = $datos['status'];
            $this->date_creation = $datos['date_creation'];

            $resp = $this->actualizarDonaciones();

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


    private function actualizarDonaciones()
    {
        $query = "UPDATE `tbl_donaciones` SET `type_products`='$this->type_products', `quantity`='$this->quantity', `description`='$this->description', `status`='$this->status',
        `date_creation`='$this->date_creation' WHERE `id_donacion` = '$this->id_donacion'";
        print_r($query);
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

        if (!isset($datos["id_donacion"])) {
            return $_respuestas->error_400();
        } else {

            $this->id_donacion = $datos['id_donacion'];

            $resp = $this->eliminarDonaciones();

            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_donacion" => $this->id_donacion
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }




    private function eliminarDonaciones()
    {
        $query = "DELETE FROM $this->tabla WHERE id_donacion='$this->id_donacion'";

        $resp = parent::noQuery($query);

        if ($resp >= 1) {
            return $resp;
        } else {
            return 0;
        }
    }
}

