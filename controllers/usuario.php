<?php
require_once "../config/respuesta.class.php";
require_once "../models/usuario.class.php";
require_once "../config/permisos.class.php";

$_encabezado = new PermisosEncabezados;
$_encabezado->PermisosEncabezados();

$_respuestas = new respuestas;
$_Usuario = new Usuario;

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if (isset($_GET["page"])) {
        $pagina = $_GET["page"];
        $listarUsuario = $_Usuario->listarUsuario($pagina);
        header("Content-Type: application/json");
        echo json_encode($listarUsuario);
        http_response_code(200);
    } 
    if (isset($_GET["countUsers"])) {
        $pagina = $_GET["countUsers"];
        $listarUsuario = $_Usuario->CountUsuario($pagina);
        header("Content-Type: application/json");
        echo json_encode($listarUsuario);
        http_response_code(200);
    } 
    
    else if (isset($_GET["id"])) {
        $UsuarioID = $_GET["id"];
        $datosUsuario = $_Usuario->obtenerUsuario($UsuarioID);
        header("Content-Type: application/json");
        echo json_encode($datosUsuario);
        http_response_code(200);
    }


}
else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    #recibir los datos enviados
    $postBody = file_get_contents("php://input");
    #enviamos los datos al manejador
    $datosArray = $_Usuario->post($postBody);

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
    $datosArray = $_Usuario->put($postBody);
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
    $datosArray = $_Usuario->delete($postBody);
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