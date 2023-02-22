<?php
require_once "../config/respuesta.class.php";
require_once "../models/rol.class.php";
require_once "../config/permisos.class.php";

$_encabezado = new PermisosEncabezados;
$_encabezado->PermisosEncabezados();

$_respuestas = new respuestas;
$_Rol = new Rol;

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if (isset($_GET["page"])) {
        $pagina = $_GET["page"];
        $listarRol= $_Rol->listarRol($pagina);
        header("Content-Type: application/json");
        echo json_encode($listarRol);
        http_response_code(200);
    } 

    else if (isset($_GET["id"])) {
        $RolID = $_GET["id"];
        $datosRol = $_Rol->obtenerRol($RolID);
        header("Content-Type: application/json");
        echo json_encode($datosRol);
        http_response_code(200);
    }

}
else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    #recibir los datos enviados
    $postBody = file_get_contents("php://input");
    #enviamos los datos al manejador
    $datosArray = $_Rol->post($postBody);

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
    $datosArray = $_Rol->put($postBody);
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
    $datosArray = $_Rol->delete($postBody);
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