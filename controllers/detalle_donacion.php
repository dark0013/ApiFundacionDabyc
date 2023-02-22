<?php
require_once "../config/respuesta.class.php";
require_once "../models/detalle_donacion.class.php";
require_once "../config/permisos.class.php";

$_encabezado = new PermisosEncabezados;
$_encabezado->PermisosEncabezados();

$_respuestas = new respuestas;
$_Detalle_donacion = new Detalle_donacion;

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if (isset($_GET["page"])) {
        $pagina = $_GET["page"];
        $listarDetalle_donacion= $_Detalle_donacion->listarDetalle_donacion($pagina);
        header("Content-Type: application/json");
        echo json_encode($listarDetalle_donacion);
        http_response_code(200);
    } 

    else if (isset($_GET["id"])) {
        $listarDetalle_donacionID = $_GET["id"];
        $datoslistarDetalle_donacion= $_Detalle_donacion->obtenerIdDetalle_donacion($_Detalle_donacionID);
        header("Content-Type: application/json");
        echo json_encode($datosDetalle_donacion);
        http_response_code(200);
    }

}
else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    #recibir los datos enviados
    $postBody = file_get_contents("php://input");
    #enviamos los datos al manejador
    $datosArray = $_Detalle_donacion->post($postBody);

    //devolvemos una respuestas
    header('Content-Type: application/json');
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($datosArray);
}
else if ($_SERVER['REQUEST_METHOD'] == "PUT") {
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    //enviamos datos al manejador
    $datosArray = $_Detalle_donacion->put($postBody);
    //delvovemos una respuesta 

    header('Content-Type: application/json');
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($datosArray);
} 
else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    //enviamos datos al manejador
    $datosArray = $_Detalle_donacion->delete($postBody);
    //delvovemos una respuesta 

    header('Content-Type: application/json');
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($datosArray);
} 

else {
    header("Content-Type: application/json");
    $datosArray = $__respuesta->error_405;
    echo json_encode($datosArray);
}
