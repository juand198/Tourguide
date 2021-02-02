<?php
require_once('../utilidades/ExcepcionApi.php');
require_once('../datos/mensajes.php');

// Esta clase representa un controlador para los turistas
class ControladorFotos
{
    /**
     * Descripcion obtiene todas las ciudades
     * @return JSON con todas las ciudades
     */
    public function registrar($mensaje)
    {
        $file = fopen("archivo.txt", "a");

        fwrite($file, $mensaje . PHP_EOL);

        fclose($file);

        return [
            [
                "estado" => ESTADO_CREACION_EXITOSA,
                "mensaje" => "OK"
            ]
        ];
    }
    
    /**
     * Descripcion obtiene todas las ciudades
     * @return JSON con todas las ciudades
     */
    public function leer()
    {
        $array = array();
        $file = fopen("archivo.txt", "r");

        while(!feof($file)) {
            array_push($array, fgets($file));
        }

	    fclose($file);

        return [
            [
                "estado" => ESTADO_CREACION_EXITOSA,
                "mensaje" => $array
            ]
        ];
    }
    
    /**
     * Descripcion obtiene todas las ciudades
     * @return JSON con todas las ciudades
     */
    public function registrarIncidencia($mensaje)
    {
        $file = fopen("incidencias.txt", "a");

        fwrite($file, $mensaje . PHP_EOL);

        fclose($file);

        return [
            [
                "estado" => ESTADO_CREACION_EXITOSA,
                "mensaje" => "OK"
            ]
        ];
    }

    /**
     * Descripcion obtiene todas las ciudades
     * @return JSON con todas las ciudades
     */
    public function leerIncidencias()
    {
        $array = array();
        $file = fopen("incidencias.txt", "r");

        while(!feof($file)) {
            array_push($array, fgets($file));
        }

	    fclose($file);

        return [
            [
                "estado" => ESTADO_CREACION_EXITOSA,
                "mensaje" => $array
            ]
        ];
    }
    /**
     * escribe de nuevo archivo.txt que es donde se encuentran nuestra fotos
     */
    public function reiniciarFotos(){
        $array = array();
        
        $file = fopen("archivo.txt", "w");

        fclose($file);
    }

    /**
     * Descripcion obtiene todas las ciudades
     * @return JSON con todas las ciudades
     */
    public function registrarReact($mensaje)
    {
        $file = fopen("archivo.txt", "a");
        $array = explode(",", $mensaje);

        foreach ($array as $valor) {
            fwrite($file, $valor. PHP_EOL);
        }        

        fclose($file);

        return [
            [
                "estado" => ESTADO_CREACION_EXITOSA,
                "mensaje" => $array
            ]
        ];
    }


}