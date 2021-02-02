<?php

// Hago que se muestren los errores si los hay
ini_set('display_errors', 1);

require_once('utilidades/ExcepcionApi.php');
require_once('vistas/VistaJson.php');
require_once('controladores/ControladorTuristas.php');
require_once('modelos/Turista.php');

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
$token = $_REQUEST['Token'];
$nombre = $_REQUEST['nombre'];
$apellidos = $_REQUEST['apellidos'];
$email = $_REQUEST['email'];
$ciudad = $_REQUEST['ciudad'];
$puntuacion = $_REQUEST['puntuacion'];
// Me creo un Usuario con los datos
$Turista = new Turista($token, $nombre, $apellidos,$ciudad,$email,$puntuacion);

// Me creo un controlador de Usuarios
$controladorU = new ControladorTuristas();

// Saco por pantalla en formato JSON el resultado
$vista->imprimir($controladorU->registrarTurista($Turista));