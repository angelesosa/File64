<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of File64
 *
 * @author Usuario
 */
class File64 {

    private $strBase64;
    private $acceptableFilesArray = array(); // example : ['jpg', 'jpeg', 'gif', 'png']
    private $fileNameAndDir;
    private $octet_stream_change = "octet-stream";
    private $readDataApplication = false;
    private $typeFile = "";

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

    function ReadDataApplicationAndSetTypeFile($bolean) {
        $this->readDataApplication = $bolean;
        return $this;
    }
    
    function setTypeFile($typeFile) {
        $this->typeFile = $typeFile;
        return $this;
    }

    
    function createFile() {
        if ($this->readDataApplication) { // en caso no tenga dataaplicacion del formato web, esto es en caso que mande la base64 en bruto
            list($header, $this->strBase64) = explode(",", $this->strBase64);
            $this->typeFile = explode(";", explode("/", $header)[1])[0];
            $this->typeFile = $typeFile === "octet-stream" ? $this->octet_stream_change : $typeFile;
        }
        if (count($this->acceptableFilesArray) > 0 && !in_array($this->typeFile, $this->acceptableFilesArray)) {
            throw new \Exception('Invalid file type');
        }
        $dataFileDecode = base64_decode($this->strBase64);
        if ($dataFileDecode === false) {
            throw new \Exception('base64_decode failed');
        }
        $this->typeFile = $this->typeFile == "" ? $this->typeFile : ".".$this->typeFile; // si es diferente a vacio agregarle el punto ".extension"
        file_put_contents($this->fileNameAndDir.$this->typeFile, $dataFileDecode);
    }

}
