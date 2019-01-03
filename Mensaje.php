<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mensaje
 *
 * @author Sistemas
 */
class Mensaje {
    
    public static $URL_PETICION_NO_VALIDA = 0;
    public static $METODO_NO_EXISTE = 1;
    public static $NO_DATA = 2;
    public static $SOLICITAR_PERMISO_ACCESO = 3;
    public static $ACCESO_DENEGADO = 4;
    public static $PERMISO_NO_VALIDO = 5;
    public static $DOMINIO_INVALIDO = 6;
    public static $CAMPOS_NO_PERMITIDO = 7;
    public static $USUARIO_REGISTRADO = 8;
    public static $VERBO_NO_VALIDO = 9;
    public static $ARCHIVO_TXT_ERROR_CREAR_ARCHIVO = 10;
    public static $ARCHIVO_NO_EXISTE = 11;

    static function imprimiMensaje($status, $mensaje, $data) {
        header("HTTP/1.1 $status $mensaje");
        header("Content-Type: application/json; charset=UTF-8");
        $response['statusCode'] = $status;
        $response['statusMessage'] = $mensaje;
        if ($data != null) {
            $response['data'] = $data;
        }
        
        if ($data == "") {
            $response['data'] = "";
        }
        
        if (is_array($data) && count($data) == 0) {
            $response['data'] = array();
        }
        
        echo json_encode($response);
    }
    
    static function okMessaje($mensaje) {
        self::imprimiMensaje(200, "Ok", $mensaje);
    }
    
    static function noDataMessaje($mensaje) {
        self::imprimiMensaje(200, "No Data", $mensaje);
    }
    
    static function errorMessaje($mensaje) {
        self::imprimiMensaje(200, "Error", $mensaje);
    }
  
    static function imprimirError($tipoError){
        switch ($tipoError){
            case self::$URL_PETICION_NO_VALIDA:
                self::imprimiMensaje(400, "Bad Request", null);
            break;
            case self::$METODO_NO_EXISTE:
                    self::imprimiMensaje(400, "Method not Allowed", null);
                break;
            case self::$NO_DATA:
                    self::imprimiMensaje(200, "No Data", null);
                break;
            case self::$SOLICITAR_PERMISO_ACCESO:
                    self::imprimiMensaje(200, "Solicitar permiso de acceso", null);
                break;
            case self::$ACCESO_DENEGADO:
                    self::imprimiMensaje(200, "Acceso denegado", null);
                break;
            case self::$PERMISO_NO_VALIDO:
                    self::imprimiMensaje(200, "Permiso no valido", null);
                break;
            case self::$DOMINIO_INVALIDO:
                    self::imprimiMensaje(200, "Dominio invalido", null);
                break;
            case self::$CAMPOS_NO_PERMITIDO:
                    self::imprimiMensaje(205, "Fields not allowed", null);
                break;
            case self::$USUARIO_REGISTRADO:
                    self::imprimiMensaje(208, "User registered", null);
                break;
            case self::$VERBO_NO_VALIDO:
                    self::imprimiMensaje(208, "Verb not allowed", null);
                break;
            case self::$ARCHIVO_TXT_ERROR_CREAR_ARCHIVO:
                    self::imprimiMensaje(208, "Ha habido un problema al crear el archivo", null);
                break;
            case self::$ARCHIVO_NO_EXISTE:
                    self::imprimiMensaje(208, "No such file", null);
                break;
        default :
            self::imprimiMensaje(402, "Bad Code Error", null);
            break;
        }
    }
}
