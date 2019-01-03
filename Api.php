<?php
ini_set("display_errors", 1);
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo ":)";
    exit();
}

$ruta = "../../AdminProyect";
//includes

//foreach (glob($ruta . "/plugins/Message/*.php") as $filename) {
//    include_once $filename;
//}

$Api = new Api();
$input = file_get_contents('php://input');
$json = json_decode($input, true);
$peticion = $json['pet'];

if (method_exists($Api, $peticion)) {
    $Api->$peticion($json);
} else {
    echo "metodo inválido: acceso denegado";
}

class File64 {

    private $strBase64;
    private $acceptableFilesArray = array(); // example : ['jpg', 'jpeg', 'gif', 'png']
    private $fileNameAndDir;
    private $octet_stream_change = "octet-stream";

    function __construct($strBase64) {
        $this->strBase64 = $strBase64;
    }

    static function create($strBase64) {
        return new File64($strBase64);
    }
    
    function change_OctetStream_To($octet_stream_change) {
        $this->octet_stream_change = $octet_stream_change;
        return $this;
    }

    function set_acceptableFilesArray($acceptableFilesArray) {
        $this->acceptableFilesArray = $acceptableFilesArray;
        return $this;
    }

    function set_fileNameAndDir($fileNameAndDir) {
        $this->fileNameAndDir = $fileNameAndDir;
        return $this;
    }

    function createFile() {
        list($header, $dataBase64) = explode(",", $this->strBase64);
        $typeFile = explode(";", explode("/", $header)[1])[0];
        $typeFile = $typeFile === "octet-stream" ? $this->octet_stream_change : $typeFile;
        if (count($this->acceptableFilesArray) > 0 && !in_array($typeFile, $this->acceptableFilesArray)) {
            throw new \Exception('Invalid file type');
        }
        $dataFileDecode = base64_decode($dataBase64);
        if ($dataFileDecode === false) {
            throw new \Exception('base64_decode failed');
        }
        file_put_contents("$this->fileNameAndDir.{$typeFile}", $dataFileDecode);
    }
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
