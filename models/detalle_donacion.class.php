<?php
require_once "../config/conexion/conexion.php";
require_once "../config/respuesta.class.php";
require_once "../config/Logs.php";

class Detalle_donacion extends conexion
{
    private $tabla = "tbl_detalle_donacion";
    private $id_detalle = "";
    private $id_donacion = "";
    private $id_producto = "";
    private $id_user = "";
    private $quantity = "";
    private $status = "";

    public function listarDetalle_donacion($pagina = 1)
    {
        $inicio = 0;
        $cantidad = 100;

        if ($pagina > 1) {
            $inicio = $cantidad * ($pagina - 1) + 1;
            $cantidad = $cantidad * $pagina;
        }

        $query = "SELECT * FROM {$this->tabla} WHERE status = 'S' LIMIT $inicio, $cantidad";
        //print_r($query);
        $datos = parent::obtenerDatos($query);
        return $datos;
    }


    public function obtenerIdDetalle_donacion($id)
    {
        $query = "select * from $this->tabla where id_user  = $id";
        return $datos = parent::obtenerDatos($query);
    }

    /* POST */


    public function post($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        if (!isset($datos["id_donacion"]) || !isset($datos["id_producto"])) {
            return $_respuestas->error_400();
        } else {
            $this->id_donacion = $datos['id_donacion'];
            $this->id_producto = $datos['id_producto'];
            $this->id_user = $datos['id_user'];
            $this->quantity = $datos['quantity'];
            $this->status = $datos['status'];

            $resp = $this->insertarDetalle_donacion();

            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "Detalle_donacionId" => $resp
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }


    private function insertarDetalle_donacion()
    {
        $query = "INSERT INTO $this->tabla(id_donacion, id_producto, id_user,quantity,status)
         VALUES ('$this->id_donacion', '$this->id_producto','$this->id_user','$this->quantity','$this->status')";
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
        if (!isset($datos["id_donacion"]) || !isset($datos["id_producto"])) {
            return $_respuestas->error_400();
        } else {
            $this->id_detalle = $datos['id_detalle'];
            $this->id_donacion = $datos['id_donacion'];
            $this->id_producto = $datos['id_producto'];
            $this->id_user = $datos['id_user'];
            $this->quantity = $datos['quantity'];
            $this->status = $datos['status'];

            $resp = $this->actualizarDetalle_donacion();

            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_detalle" => $resp
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }


    private function actualizarDetalle_donacion()
    {
        $query = "UPDATE `tbl_detalle_donacion` SET `id_donacion`='$this->id_donacion', `id_producto`='$this->id_producto', `id_user`='$this->id_user', `quantity`='$this->quantity',
        `status`='$this->status' WHERE `id_detalle` = '$this->id_detalle'";
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

        if (!isset($datos["id_detalle"])) {
            return $_respuestas->error_400();
        } else {

            $this->id_detalle = $datos['id_detalle'];

            $resp = $this->eliminarDetalle_donacion();

            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_detalle" => $this->id_detalle
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }




    private function eliminarDetalle_donacion()
    {
        $query = "UPDATE `tbl_detalle_donacion` SET `status` ='I' WHERE `id_detalle` = '$this->id_detalle'";

        $resp = parent::noQuery($query);

        if ($resp >= 1) {
            return $resp;
        } else {
            return 0;
        }
    }
}

