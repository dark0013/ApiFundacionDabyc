<?php
require_once "../config/conexion/conexion.php";
require_once "../config/respuesta.class.php";
require_once "../config/Logs.php";

class Productos extends conexion

{
  private $tabla = "tbl_productos";
  private $id_product = "";
  private $name = "";
  private $quantity = "";
  private $tipe_products = "";
  private $status = "";
  private $description = "";
  private $user_sesion = "";
  private $date_creation = "";
  private $user_creation = "";
  private $user_update = "";

  public function listarProductos($pagina = 1)
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


  public function obtenerProductos($id)
  {
    $query = "select * from $this->tabla where id_user  = $id";
    return $datos = parent::obtenerDatos($query);
  }

  /* POST */


  public function post($json)
  {
    $_respuestas = new respuestas;
    $datos = json_decode($json, true);
    if (!isset($datos["name"]) || !isset($datos["user_sesion"])) {
      return $_respuestas->error_400();
    } else {
      $this->name = $datos['name'];
      $this->quantity = $datos['quantity'];
      $this->tipe_products = $datos['tipe_products'];
      $this->status = $datos['status'];
      $this->description = $datos['description'];
      $this->user_sesion = $datos['user_sesion'];
      $this->date_creation = $datos['date_creation'];
      $this->user_creation = $datos['user_creation'];

      $resp = $this->insertarProductos();

      if ($resp) {
        $respuesta = $_respuestas->response;
        $respuesta["result"] = array(
          "ProductosId" => $resp
        );

        return $respuesta;
      } else {
        return $_respuestas->error_500();
      }
    }
  }


  private function insertarProductos()
  {
    $query = "INSERT INTO $this->tabla(id_product, name, quantity, tipe_products,  status, description, user_sesion,date_creation,user_creation)
         VALUES ('$this->id_product', '$this->name', '$this->quantity','$this->tipe_products','$this->status', '$this->description', '$this->user_sesion', '$this->date_creation', '$this->user_creation')";
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
    if (!isset($datos["name"]) || !isset($datos["user_sesion"])) {
      return $_respuestas->error_400();
    } else {
      $this->id_product = $datos['id_product'];
      $this->name = $datos['name'];
      $this->quantity = $datos['quantity'];
      $this->tipe_products = $datos['tipe_products'];
      $this->status = $datos['status'];
      $this->description = $datos['description'];
      $this->user_sesion = $datos['user_sesion'];
      $this->date_creation = $datos['date_creation'];
      $this->user_creation = $datos['user_creation'];

      $resp = $this->actualizarProductos();

      if ($resp) {
        $respuesta = $_respuestas->response;
        $respuesta["result"] = array(
          "id_product" => $resp
        );

        return $respuesta;
      } else {
        return $_respuestas->error_500();
      }
    }
  }


  private function actualizarProductos()
  {
    $query = "UPDATE `tbl_productos` SET `name` = '$this->name',`quantity` = '$this->quantity',`tipe_products` = '$this->tipe_products' ,`status`='$this->status', `description`='$this->description', 
        `user_sesion`='$this->user_sesion', `date_creation`='$this->date_creation', `user_creation`='$this->user_creation', `user_update`='$this->user_update' WHERE `id_product` = '$this->id_product'";
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

    if (!isset($datos["id_product"])) {
      return $_respuestas->error_400();
    } else {

      $this->id_product = $datos['id_product'];

      $resp = $this->eliminarProductos();

      if ($resp) {
        $respuesta = $_respuestas->response;
        $respuesta["result"] = array(
          "id_product" => $this->id_product
        );

        return $respuesta;
      } else {
        return $_respuestas->error_500();
      }
    }
  }




  private function eliminarProductos()
  {
    $query = "DELETE FROM $this->tabla WHERE id_product='$this->id_product'";

    $resp = parent::noQuery($query);

    if ($resp >= 1) {
      return $resp;
    } else {
      return 0;
    }
  }
}
