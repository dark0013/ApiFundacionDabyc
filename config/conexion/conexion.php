<?php
require_once "../config/Logs.php";

class conexion
{

    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    private $conexion;


    function __construct()
    {
        $errorLogs = new ErrorLogs();
        try {
            $listadatos = $this->datosConexion();
            foreach ($listadatos as $key => $value) {
                $this->server = $value['server'];
                $this->user = $value['user'];
                $this->password = $value['password'];
                $this->database = $value['database'];
                $this->port = $value['port'];
            }
            if (!isset($value['server']) || !isset($value['user']) || !isset($value['password']) || !isset($value['database']) || !isset($value['port'])) {
                throw new Exception("Falta información en los datos de conexión");
            } else {
                $this->conexion = new mysqli($this->server, $this->user, $this->password, $this->database, $this->port);
                if ($this->conexion->connect_errno) {
                    throw new Exception("Error en la conexión a la base de datos: " . $this->conexion->connect_errno);
                }
            }
        } catch (Exception $e) {
            $_errores = "algo va mal con la conexion";
            $array = array("error_id" => "500", "error_msg" => $_errores);

            echo json_encode($array);
            $errorLogs->logException($e);
            die();
        }
    }

    private function datosConexion()
    {
        $direccion = dirname(__FILE__);
        $jsondata = file_get_contents($direccion . "/" . "config");
        return json_decode($jsondata, true);
    }


    private function convertirUTF8($array)
    {
        array_walk_recursive($array, function (&$item, $key) {
            if (!mb_detect_encoding($item, 'utf-8', true)) {
                $item = utf8_encode($item);
            }
        });
        return $array;
    }


    public function callProcedure($sqlstr)
    {
        $resultArray = array();
        $stmt = mysqli_prepare($this->conexion, $sqlstr);
        mysqli_stmt_execute($stmt);
        
        // Fetch the results of the stored procedure
        $select = mysqli_query($this->conexion, "SELECT @p0 AS COD_RESPONSE, @p1 AS MENSAGE_RESPONSE;");
        $result = mysqli_fetch_assoc($select);
        
        // Add the results to the result array
        $resultArray[] = $result;
        
        return $this->convertirUTF8($resultArray);
    }
    


    public function obtenerDatos($sqlstr)
    {
        $results = $this->conexion->query($sqlstr);
        $resultArray = array();
        foreach ($results as $key) {
            $resultArray[] = $key;
        }

        return $this->convertirUTF8($resultArray);
    }

    public function noQuery($sqlstr)
    {
        $results = $this->conexion->query($sqlstr);
        return $this->conexion->affected_rows;
    }

    //solo para insert
    public function noQueryId($sqlstr)
    {
        $results = $this->conexion->query($sqlstr);
        $filas = $this->conexion->affected_rows;
        if ($filas >= 1) {
            return $this->conexion->insert_id;
        } else {
            return 0;
        }
    }

    //encriptar
    protected function encriptar($string)
    {
        return md5($string);
    }
}
$_conexion = new conexion();
