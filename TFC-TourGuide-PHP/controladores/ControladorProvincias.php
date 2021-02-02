<?php
require_once('datos/ConexionBD.php');
require_once('utilidades/ExcepcionApi.php');
require_once('datos/mensajes.php');

// Esta clase representa un controlador para los turistas
class ControladorProvincias
{
    // Nombdres de la tabla y de los atributos
	const NOMBRE_TABLA = "provincias";
	const ID = "ID";
    const NOMBRE = "nombre";
    const IDComunidad = "IDComunidad";

    /**
     * Descripcion obtiene todas las ciudades
     * @return JSON con todas las ciudades
     */
    public function obtenerProvincias()
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
	/**
	 * 
	 */
	public function obtenerProvinciaFoto($nombre)
    {
		try 
		{
		    $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

			$comando = "SELECT p.* FROM ".self::NOMBRE_TABLA." p INNER JOIN ciudades c on p.ID = c.IDProvincia where c.nombre = ?";
            $sentencia = $pdo->prepare($comando);
			
			$sentencia->bindParam(1,$nombre);
            
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