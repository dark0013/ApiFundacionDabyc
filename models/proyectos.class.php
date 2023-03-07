<?php
require_once "../config/conexion/conexion.php";
require_once "../config/respuesta.class.php";
require_once "../config/Logs.php";

class Proyectos extends conexion
{

    private $tabla = "tbl_proyectos";
    private $id_project = "";
    private $title = "";
    private $url_image = "";
    private $image = "";
    private $description = "";
    private $rol_user = "";
    private $estado = "";
    private $user_sesion = "";
    private $date_creation = "";
    private $usur_creation = "";
    private $user_update = "";

    public function listarProyectos($pagina = 1)
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


    public function obtenerProyectos($id)
    {
        $query = "select * from $this->tabla where id_user  = $id";
        return $datos = parent::obtenerDatos($query);
    }

    /* POST */


    public function post($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);


        /*    if (isset($datos['imagen'])) {
           // $resp =    $this->procesarImagen($datos['imagen']);
            $this->image =   $this->procesarImagen($datos['imagen']);
              echo  ($this->image); 
        } */

        if (!isset($datos["title"]) || !isset($datos["user_sesion"])) {
            return $_respuestas->error_400();
        } else {
            $this->title = $datos['title'];


            $this->url_image =  $this->procesarImagen($datos['url_image']);


            $this->image = $datos['image'];
            $this->description = $datos['description'];
            $this->rol_user = $datos['rol_user'];
            $this->estado = $datos['estado'];
            $this->user_sesion = $datos['user_sesion'];
            $this->date_creation = $datos['date_creation'];
            $this->usur_creation = $datos['usur_creation'];

            $resp = $this->insertarProyectos();

            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "ProyectosId" => $resp
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }


    private function insertarProyectos()
    {
        $query = "INSERT INTO $this->tabla(id_project, title, url_image, image,  description, rol_user, estado,user_sesion,date_creation,usur_creation)
        VALUES ('$this->id_project', '$this->title', '$this->url_image','$this->image','$this->description', '$this->rol_user', '$this->estado', '$this->user_sesion', '$this->date_creation', '$this->usur_creation')";
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
            $this->id_project = $datos['id_project'];
            $this->title = $datos['title'];
            $this->url_image =  $this->procesarImagen($datos['url_image']);
            $this->image = $datos['image'];
            $this->description = $datos['description'];
            $this->rol_user = $datos['rol_user'];
            $this->estado = $datos['estado'];
            $this->user_sesion = $datos['user_sesion'];
            $this->date_creation = $datos['date_creation'];
            $this->usur_creation = $datos['usur_creation'];


            $resp = $this->actualizarProyectos();

            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_project" => $resp
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }


    private function actualizarProyectos()
    {
        $query = "UPDATE `tbl_proyectos` SET `title` = '$this->title',`url_image` = '$this->url_image',`image` = '$this->image' ,`description`='$this->description', `rol_user`='$this->rol_user', 
         `estado`='$this->estado', `user_sesion`='$this->user_sesion', `date_creation`='$this->date_creation', `usur_creation`='$this->usur_creation', `user_update`='$this->user_update' WHERE `id_project` = '$this->id_project'";
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

        if (!isset($datos["id_project"])) {
            return $_respuestas->error_400();
        } else {

            $this->id_project = $datos['id_project'];

            $resp = $this->eliminarProyectos();

            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_project" => $this->id_project
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }




    private function eliminarProyectos()
    {
        $query = "DELETE FROM $this->tabla WHERE id_project='$this->id_project'";

        $resp = parent::noQuery($query);

        if ($resp >= 1) {
            return $resp;
        } else {
            return 0;
        }
    }



    private function procesarImagen($imagen)
    {
        // Obtener la ruta base de la aplicación en el servidor
        $ruta_base = $_SERVER['DOCUMENT_ROOT'] . '/ApiFundacionDabyc/public/imagenes/';

        // Obtener la extensión de la imagen a partir del tipo MIME
        $partes = explode(";base64,", $imagen);
        $mime_type = $partes[0];
        $extension = explode("/", $mime_type)[1];

        // Decodificar la imagen base64 a su formato binario original
        $imagen_binaria = base64_decode($partes[1]);

        // Generar un nombre único para el archivo de imagen
        $nombre_archivo = uniqid() . "." . $extension;

        // Guardar la imagen en el servidor
        $ruta_archivo = $ruta_base . $nombre_archivo;
        file_put_contents($ruta_archivo, $imagen_binaria);

        // Devolver la URL completa de la imagen guardada
        return 'http://' . $_SERVER['HTTP_HOST'] . '/ApiFundacionDabyc/public/imagenes/' . $nombre_archivo;
    }
}
