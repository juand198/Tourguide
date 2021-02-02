<?php

// Hago que se muestren los errores si los hay
ini_set('display_errors', 1);
require_once('../utilidades/ExcepcionApi.php');
require_once('../vistas/VistaJson.php');
require_once('ControladorFotos.php');

// Tipo de vista de la salida de datos.
$vista = new VistaJson();

// Con esta funci�n nos aseguramos que cualquier excepci�n que ocurra se muestre adecuadamente
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
$mensaje = $_REQUEST['mensaje'];

// Me creo un controlador de Usuarios
$controladorU = new ControladorFotos();

// Saco por pantalla en formato JSON el resultado
$vista->imprimir($controladorU->registrarIncidencia($mensaje));