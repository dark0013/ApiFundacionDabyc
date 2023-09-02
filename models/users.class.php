<?php

require_once "../config/conexion/conexion.php";
require_once "../config/respuesta.class.php";
require_once "../config/Logs.php";


class Usuario extends conexion
{
    private $tabla = "users";
    private $iduser = "";
    private $username = "";
    private $password = "";
    private $name = "";
    private $cellphone = "";
    private $lastname = "";
    private $email = "";
    private $imagen = "";
    private $activo = "";
    private $delete = "";
    private $date_registro = "";

    /*  Mostrar   */

    public function listarUsuario($pagina = 1)
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

    public function obtenerUsuario($id)
    {
        $query = "select * from $this->tabla where iduser  = $id";
        return $datos = parent::obtenerDatos
        ($query);
    }

    public function CountUsuario($id)
    {
        $query = "SELECT COUNT(*) as totalUser FROM $this->tabla where activo = 'A'";
        return $datos = parent::obtenerDatos($query);
    }


    /* POST */


    public function post($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        if (
            !isset($datos["username"]) || !isset($datos["password"]) || !isset($datos["name"]) || !isset($datos["cellphone"])
            || !isset($datos["lastname"]) || !isset($datos["email"]) || !isset($datos["activo"]) || !isset($datos["delete"]) || !isset($datos["date_registro"])
        ) {

            return $_respuestas->error_400();
        } else {
            $this->username = $datos['username'];
            $this->password = $datos['password'];
            $this->name = $datos['name'];
            $this->cellphone = $datos['cellphone'];
            $this->lastname = $datos['lastname'];
            $this->email = $datos['email'];
            $this->imagen = $this->procesarImagen($datos['imagen']);
            $this->activo = $datos['activo'];
            $this->delete = $datos['delete'];
            $this->date_registro = $datos['date_registro'];

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
        $query = "INSERT INTO `users`(username,`password`, `name`, cellphone, lastname, email, imagen,activo,`delete`,date_registro) 
        VALUES ('$this->username','$this->password', '$this->name','$this->cellphone', '$this->lastname', '$this->email', '$this->imagen', '$this->activo','$this->delete','$this->date_registro')";

        $resp = parent::noQueryId($query);

        if ($resp) {
            return $resp;
        } else {
            return 0;
        }
    }



    /* PUT */

    public function put($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        if (
            !isset($datos["username"]) || !isset($datos["password"]) || !isset($datos["name"]) || !isset($datos["cellphone"])
            || !isset($datos["lastname"]) || !isset($datos["email"]) || !isset($datos["activo"]) || !isset($datos["delete"]) || !isset($datos["date_update"])
        ) {
            return $_respuestas->error_400();
        } else {

            $this->iduser = $datos['iduser'];
            $this->username = $datos['username'];
            $this->password = $datos['password'];
            $this->name = $datos['name'];
            $this->cellphone = $datos['cellphone'];
            $this->lastname = $datos['lastname'];
            $this->email = $datos['email'];
            $this->imagen = $this->procesarImagen($datos['imagen']);
            $this->activo = $datos['activo'];
            $this->delete = $datos['delete'];
            $this->date_update = $datos['date_update'];

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
        $query = "UPDATE `users` SET `username` ='$this->username', `password`='$this->password', `name`='$this->name', `cellphone`='$this->cellphone', 
        `lastname`='$this->lastname',`email`='$this->email', `imagen`='$this->imagen', `activo`='$this->activo',`delete`='$this->delete',
        `date_update`='$this->date_update' WHERE `iduser` = '$this->iduser'";

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

        if (!isset($datos["iduser"])) {
            return $_respuestas->error_400();
        } else {

            $this->iduser = $datos['iduser'];
            $this->date_delete = $datos['date_delete'];

            $resp = $this->eliminarUsuario();

            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "Usuariosid" => $resp
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }




    private function eliminarUsuario()
    {
        $query = "UPDATE `users` SET `activo` ='I', `delete`=1, `date_delete`='$this->date_delete' WHERE `iduser` = '$this->iduser'";

        $resp = parent::noQuery($query);

        if ($resp >= 1) {
            return $resp;
        } else {
            return 0;
        }
    }


    private function procesarImagen($imagen_url)
{
    // Obtener la ruta base de la aplicación en el servidor
    $ruta_base = $_SERVER['DOCUMENT_ROOT'] . '/ApiAppMovil/public/imagenes/';

    // Obtener el nombre del archivo de la URL
    $nombre_archivo = basename($imagen_url);

    // Verificar si el archivo ya existe en la carpeta de imágenes
    if (!file_exists($ruta_base . $nombre_archivo)) {
        // Si el archivo no existe, obtener la imagen binaria a partir de la URL
        $imagen_binaria = file_get_contents($imagen_url);

        // Guardar la imagen en el servidor
        $ruta_archivo = $ruta_base . $nombre_archivo;
        file_put_contents($ruta_archivo, $imagen_binaria);
    }

    // Devolver la URL completa de la imagen guardada
    //return 'http://' . $_SERVER['HTTP_HOST'] . '/ApiAppMovil/public/imagenes/' . $nombre_archivo;
    return 'https://' . $_SERVER['HTTP_HOST'] . '/ApiAppMovil/public/imagenes/' . $nombre_archivo;
}

}