<?php

// Hago que se muestren los errores si los hay
ini_set('display_errors', 1);

require_once('utilidades/ExcepcionApi.php');
require_once('vistas/VistaJson.php');
require_once('controladores/ControladorAnuncios.php');
require_once('modelos/Anuncio.php');

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
$idturista = $_REQUEST['idturista'];
$ciudad = $_REQUEST['idciudad'];
$acompanantes = $_REQUEST['acompanantes'];
$idtipo = $_REQUEST['idtipo'];
$nombre = $_REQUEST['nombreviaje'];
$fechacreacion = $_REQUEST['fechacreacion'];
$fecha1 = $_REQUEST['fechainicio'];
$fecha2 = $_REQUEST['fechafin'];
$mensaje = $_REQUEST['mensaje'];
$estado = $_REQUEST['estado'];

// Me creo un Usuario con los datos

$Anuncio = new Anuncio($idturista,$ciudad,$idtipo,$nombre,$acompanantes,$fechacreacion,$fecha1,$fecha2,$mensaje,$estado);

// Me creo un controlador de Usuarios
$controladorU = new ControladorAnuncios();

// Saco por pantalla en formato JSON el resultado
$vista->imprimir($controladorU->publicarAnuncio($Anuncio));