<?php
require_once('datos/ConexionBD.php');
require_once('utilidades/ExcepcionApi.php');
require_once('datos/mensajes.php');

// Esta clase representa un controlador para los turistas
class ControladorCiudades
{
    // Nombdres de la tabla y de los atributos
	const NOMBRE_TABLA = "ciudades";
	const ID = "ID";
    const NOMBRE = "Nombre";
	const IDPROVINCIA = "IDProvincia";
	const PROVINCIA = "provincias";

    /**
     * Descripcion obtiene todas las ciudades
     * @return JSON con todas las ciudades
     */
    public function obtenerCiudades($ciudad)
    {
		try 
		{
		    $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

		    $comando = "SELECT * FROM " . self::NOMBRE_TABLA . " WHERE IDProvincia = (Select ".self::ID." from ".self::PROVINCIA." Where ".self::NOMBRE." = ?)";
			$sentencia = $pdo->prepare($comando);
			
			$sentencia->bindValue(1, $ciudad);
			
		    $sentencia->execute();

		    $array = array();

		    while ($row = $sentencia->fetch(PDO::FETCH_ASSOC)) 
		    { 
				array_push($array, $row);
			}

			return [
            	[
               	 	"estado" => ESTADO_CREACION_EXITOSA,
                	"mensaje" => $array
                ]
            ];
		} 
		catch (PDOException $e) 
		{
		    throw new ExcepcionApi(ESTADO_ERROR_BD, $e->getMessage());
		}
	}
	

	/**
     * Descripcion obtiene todas las ciudades
     * @return JSON con todas las ciudades
     */
    public function obtenerTodasCiudades()
    {
		try 
		{
		    $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

		    $comando = "SELECT * FROM " . self::NOMBRE_TABLA;
			$sentencia = $pdo->prepare($comando);
			
		    $sentencia->execute();

		    $array = array();

		    while ($row = $sentencia->fetch(PDO::FETCH_ASSOC)) 
		    { 
				array_push($array, $row);
			}

			return [
            	[
               	 	"estado" => ESTADO_CREACION_EXITOSA,
                	"mensaje" => $array
                ]
            ];
		} 
		catch (PDOException $e) 
		{
		    throw new ExcepcionApi(ESTADO_ERROR_BD, $e->getMessage());
		}
    }


}