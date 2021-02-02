<?php

// Hago que se muestren los errores si los hay
ini_set('display_errors', 1);

require_once('vistas/VistaJson.php');
require_once('controladores/ControladorMensajes.php');
require_once('modelos/Mensaje.php');

const API_ACCESS_KEY = "AIzaSyDDaUJcLQRJH9S8JCE_wjM_XCr-8SkVLm4";

// Tipo de vista de la salida de datos.
$vista = new VistaJson();

// Con esta función nos aseguramos que cualquier excepción que ocurra se muestre adecuadamente
// en el mismo formato para evitar problemas.
set_exception_handler(function ($exception) use ($vista) 
	{
	    $cuerpo = array(
	    	array(
	        	"estado" => $exception->estado,
	        	"mensaje" => $exception->getMessage()
	    	)
	    );
	    if ($exception->getCode()) 
	    {
	        $vista->estado = $exception->getCode();
	    } 
	    else 
	    {
	        $vista->estado = 500;
	    }

	    $vista->imprimir($cuerpo);
	}
);

// Obtengo los datos pasados por POST
$emisor = $_REQUEST['emisor'];
$receptor = $_REQUEST['receptor'];
$titulo = $_REQUEST['titulo'];
$mensaje = $_REQUEST['mensaje'];

// Me creo un controlador de Mensajes
$controladorM = new ControladorMensajes();
$Mensaje = new Mensaje($titulo, $mensaje);
// Saco por pantalla en formato JSON el resultado
$vista->imprimir($controladorM->enviarMensajeUsuario($emisor,$receptor,$Mensaje));