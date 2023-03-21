<?php
require_once "../config/respuesta.class.php";
require_once "../models/donaciones.class.php";
require_once "../config/permisos.class.php";

$_encabezado = new PermisosEncabezados;
$_encabezado->PermisosEncabezados();

$_respuestas = new respuestas;
$_Donaciones = new Donaciones;

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if (isset($_GET["page"])) {
        $pagina = $_GET["page"];
        $listarDonaciones= $_Donaciones->listarDonaciones($pagina);
        header("Content-Type: application/json");
        echo json_encode($listarDonaciones);
        http_response_code(200);
    } 

    else if (isset($_GET["id"])) {
        $listarDonacionesID = $_GET["id"];
        $datoslistarDonaciones = $_Donaciones->obtenerIDonaciones($_DonacionesID);
        header("Content-Type: application/json");
        echo json_encode($datosDonaciones);
        http_response_code(200);
    }
    else if (isset($_GET["info"])) {
        $postBody = file_get_contents("php://input");
        $datosReportDonaciones = $_Donaciones->reportDonaciones($postBody);
        header("Content-Type: application/json");
        echo json_encode($datosReportDonaciones);
        http_response_code(200);
    }
    else if (isset($_GET["pageD"])) {
        $pagina = $_GET["pageD"];
        $obtenerDonantes= $_Donaciones->obtenerDonantes($pagina);
        header("Content-Type: application/json");
        echo json_encode($obtenerDonantes);
        http_response_code(200);
    } 

}
else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    #recibir los datos enviados
    $postBody = file_get_contents("php://input");
    #enviamos los datos al manejador
    $datosArray = $_Donaciones->post($postBody);

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
    $datosArray = $_Donaciones->put($postBody);
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
    $datosArray = $_Donaciones->delete($postBody);
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
