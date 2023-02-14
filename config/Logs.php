<?php
class ErrorLogs
{

    /*     public function logException($exception)
    {
        // Obtener la fecha y hora actual
        $date = date("Y-m-d");
        $dateFile = date("Y-m-d H:i:s");
        $logFile = __DIR__ . "\logs\\error_{$date}.txt";
        
        // Obtener información sobre la función que causó la excepción

        $backtrace = debug_backtrace();
        if (isset($backtrace[1]['function'])) {
            $function = $backtrace[1]['function'];
        } else {
            $function = 'Unknown function';
        }

        // Crear el mensaje de registro con la fecha y hora, nombre de la función y mensaje de excepción
        $message = "$dateFile - $function - Excepción: " . $exception->getMessage() . "\n";

        // Escribir el mensaje de registro en el archivo de log
        file_put_contents($logFile, $message, FILE_APPEND);
    } */

    public function logException($exception)
    {
        // Obtener la fecha y hora actual
        $date = date("Y-m-d");
        $dateFile = date("Y-m-d H:i:s");
        $logFile = __DIR__ . "/../Logs/error_{$date}.txt";
        $l =  __DIR__ . "\logs\\error_{$date}.txt";

        // Obtener información sobre la función que causó la excepción
        $backtrace = debug_backtrace();
        if (isset($backtrace[1]['function'])) {
            $function = $backtrace[1]['function'];
        } else {
            $function = 'Unknown function';
        }

        // Crear el mensaje de registro con la fecha y hora, nombre de la función y mensaje de excepción
        $message = "$dateFile - $function - Excepción: " . $exception->getMessage() . "\n";

        // Escribir el mensaje de registro en el archivo de log
        file_put_contents($logFile, $message, FILE_APPEND);
    }
}


/* function hola($message)
{
    throw new Exception($message);
}

try {
    hola("Esta es una excepción");
} catch (Exception $e) {
    $errorLogs = new ErrorLogs();
    $errorLogs->logException($e);
} */
