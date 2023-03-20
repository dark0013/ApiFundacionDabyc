<?php
require_once "../config/conexion/conexion.php";
require_once "../config/respuesta.class.php";
require_once "../config/Logs.php";

class Donaciones extends conexion
{
    private $tabla = "tbl_donaciones";
    private $id_donacion = "";
    private $name = "";
    private $dni = "";
    private $email = "";
    private $cellPhone = "";
    private $type_products = "";
    private $donaciones = "";
    private $user = "";

    // private $type_products = "";
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


    public function obtenerIDonaciones($id)
    {
        $query = "select * from $this->tabla where id_user  = $id";
        return $datos = parent::obtenerDatos($query);
    }

    public function reportDonaciones($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        $select = "SELECT * FROM `tbl_donaciones`";

        $where = "";
        $fecha = "";

        echo "===>" . $datos["fecha_fin"];

        if (($datos["dni"] != "") && ($datos["fecha_inicio"] == "") && ($datos["fecha_fin"] == "")) {
            $where = " WHERE `cedula` = '" . $datos["dni"] . "'";
        } else if (($datos["dni"] == "") && ($datos["fecha_inicio"] != "") && ($datos["fecha_fin"] != "")) {
            $where = " WHERE `cedula` = '" . $datos["dni"] . "'";
            $fecha = " AND DATE_FORMAT(date_creation, '%d/%m/%Y') >= '" . $datos["fecha_inicio"] . "'
                AND DATE_FORMAT(date_creation, '%d/%m/%Y') <= '" . $datos["fecha_fin"] . "'";
        } else if (($datos["dni"] == "") && ($datos["fecha_inicio"] == "") && ($datos["fecha_fin"] == "")) {
            $select = "SELECT * FROM `tbl_donaciones`";
        }

        $query = $select . $where . $fecha;
        $resp = parent::obtenerDatos($query);

        if ($resp) {
            $respuesta = $_respuestas->response;
            $respuesta["result"] = $resp;

            return $respuesta;
        } else {
            return $_respuestas->error_200("No hay registro");
        }

    }



    /* POST */


    public function post($json)
    {

        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        // print_r($datos);
        if (!isset($datos["type_products"]) || !isset($datos["dni"])) {
            print_r($datos);
            return $json;
        } else {

            $this->name = $datos['name'];
            $this->dni = $datos['dni'];
            $this->email = $datos['email'];
            $this->cellPhone = $datos['cellPhone'];
            $this->type_products = $datos['type_products'];
            $this->donaciones = $datos['donaciones'];

            $resp = $this->insertarDonaciones();


            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_information" => $resp,
                    "cadena =>" => $json
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    private function insertarDonaciones()
    {
        $campos = "INSERT INTO `tbl_donaciones`(`type_products`, `quantity`, `description`, `nombres_apellidos`, `cedula`, `telefono`, `correo`) ";

        $donacionJson = json_decode($this->donaciones);

        foreach ($donacionJson as $donacion) {
            $producto = $donacion->producto;
            $cantidad = $donacion->cantidad;

            $insert = "VALUES ('$producto','$cantidad','$this->description','$this->name','$this->dni','$this->cellPhone','$this->email')";
            $query = $campos . $insert;

            $resp = parent::noQueryId($query);

            if (!$resp) {
                return 0;
            }
        }

        return $resp;
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
