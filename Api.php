<?php
ini_set("display_errors", 1);
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo ":)";
    exit();
}

//$ruta = "../../AdminProyect";
//includes

//foreach (glob($ruta . "/plugins/Message/*.php") as $filename) {
//    include_once $filename;
//}

include_once './Mensaje.php';
include_once './File64.php';

$Api = new Api();
$input = file_get_contents('php://input');
$json = json_decode($input, true);
$peticion = $json['pet'];

if (method_exists($Api, $peticion)) {
    $Api->$peticion($json);
} else {
    echo "metodo inválido: acceso denegado";
}

class Api {

    var $fecha;

    function __construct() {
        $this->fecha = gmdate('Y-m-d H:i:s', time() - 18000);
    }

    function prueba($json) {

        File64::create($json['base64'])
                ->set_fileNameAndDir("prueba")
                ->change_OctetStream_To("rar")
                ->createFile();

        Mensaje::okMessaje("Archivo creado");
    }

}
