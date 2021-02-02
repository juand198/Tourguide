<?php

require_once('datos/ConexionBD.php');
require_once('utilidades/ExcepcionApi.php');
require_once('datos/mensajes.php');

// Esta clase representa un controlador para los turistas
class ControladorTuristas
{
    // Nombdres de la tabla y de los atributos
	const NOMBRE_TABLA = "turista";
	const ID = "ID";
    const NOMBRE = "Nombre";
    const APELLIDOS = "Apellidos";
    const CIUDAD = "IDCiudad";
    const EMAIL = "Email";
    const TOKEN = "Token";
    const PUNTUACION = "Puntuacion";

    /**
	 * Descripción: Inserta una turista en la base de datos
	 * @param turista turista para insertar en la base de datos
	 * @return Indica si se ha insertado la usuario correctamente (Código 1)
	 */
    public function registrarTurista($turista)
    {
        try 
        {
            // Obtengo una instancia de la base de datos ya conectada
            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

            // Creo la sentencia INSERT
            $comando = "INSERT INTO ".self::NOMBRE_TABLA."(
                                                            ".self::TOKEN.", 
                                                            ".self::CIUDAD.", 
                                                            ".self::NOMBRE.", 
                                                            ".self::APELLIDOS.", 
                                                            ".self::EMAIL.",
                                                            ".self::PUNTUACION."
                                                            ) 
                            VALUES (
                            ?,
                            (SELECT `ID` FROM `ciudades` WHERE `nombre` = ?),
                            ?,
                            ?,
                            ?,
                            ?
                            )";

            $sentencia = $pdo->prepare($comando);
            // Pongo los datos en la consulta INSERT
            $sentencia->bindValue(1, $turista->getToken(),PDO::PARAM_STR);
            $sentencia->bindValue(2, $turista->getCiudad(),PDO::PARAM_STR);
            $sentencia->bindValue(3, $turista->getNombre(),PDO::PARAM_STR);
            $sentencia->bindValue(4, $turista->getApellidos(),PDO::PARAM_STR);
            $sentencia->bindValue(5, $turista->getEmail(),PDO::PARAM_STR);
            $sentencia->bindValue(6, $turista->getPuntuacion(),PDO::PARAM_STR);
            // Ejecuto la consulta
            $resultado = $sentencia->execute();
        } 
        catch (PDOException $e) 
        {
            throw new ExcepcionApi(ESTADO_ERROR_BD, $e->getMessage());
        }

        switch ($resultado) 
        {
            case ESTADO_CREACION_EXITOSA:
                http_response_code(200);
                return correcto;
                break;
            case ESTADO_CREACION_FALLIDA:
                throw new ExcepcionApi(ESTADO_CREACION_FALLIDA, "Ha ocurrido un error.");
                break;
            default:
                throw new ExcepcionApi(ESTADO_FALLA_DESCONOCIDA, "Fallo desconocido.", 400);
        }
    }

    /**
     * Descripción: Elimina un turista en la base de datos
     * @param token turista para eliminar en la base de datos
     * @return Indica si se ha eliminado el turista correctamente (Código 1)
     */
    public function eliminarTurista($token)
    {
        try 
        {
            // Obtengo una instancia de la base de datos ya conectada
            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

            // Creo la sentencia INSERT
            $comando = "DELETE FROM ". self::NOMBRE_TABLA. " WHERE ".self::TOKEN." = ?";

            $sentencia = $pdo->prepare($comando);

            // Pongo los datos en la consulta INSERT
            $sentencia->bindValue(1, $token);

            // Ejecuto la consulta
            $resultado = $sentencia->execute();
        } 
        catch (PDOException $e) 
        {
            throw new ExcepcionApi(ESTADO_ERROR_BD, $e->getMessage());
        }

        switch ($resultado) 
        {
            case ESTADO_CREACION_EXITOSA:
                http_response_code(200);
                return correcto;
                break;
            case ESTADO_CREACION_FALLIDA:
                throw new ExcepcionApi(ESTADO_CREACION_FALLIDA, "Ha ocurrido un error.");
                break;
            default:
                throw new ExcepcionApi(ESTADO_FALLA_DESCONOCIDA, "Fallo desconocido.", 400);
        }
    }

    /**
     * Descripción: updatea un turista de la base de datos
     * @param turista turista para insertar en la base de datos
     * @return Indica si se ha insertado la usuario correctamente (Código 1)
     */
    /*public function UpdateUsuario($token,$oldusuario)
    {
        try 
        {
            // Obtengo una instancia de la base de datos ya conectada
            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

            // Creo la sentencia INSERT
            $comando = "UPDATE ". self::NOMBRE_TABLA .
            " SET token=? WHERE usuario = ?";
            $sentencia = $pdo->prepare($comando);
            // Pongo los datos en la consulta INSERT
            $sentencia->bindParam(1, $token);
            $sentencia->bindParam(2, $oldusuario);

            // Ejecuto la consulta
            $resultado = $sentencia->execute();
        } 
        catch (PDOException $e) 
        {
            throw new ExcepcionApi(ESTADO_ERROR_BD, $e->getMessage());
        }

        switch ($resultado) 
        {
            case ESTADO_CREACION_EXITOSA:
                http_response_code(200);
                return correcto;
                break;
            case ESTADO_CREACION_FALLIDA:
                throw new ExcepcionApi(ESTADO_CREACION_FALLIDA, "Ha ocurrido un error.");
                break;
            default:
                throw new ExcepcionApi(ESTADO_FALLA_DESCONOCIDA, "Fallo desconocido.", 400);
        }
    }*/

    /**
     * Descripcion obtiene un turista en funcion de su id
     * @param token  id del turista a buscar
     * @return JSON que indica si se ha insertado la usuario correctamente (Código 1)
     */
    public function obtenerTurista($token)
    {
		try 
		{
		    $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

		    // Sentencia SELECT
		    $comando = "SELECT * FROM " . self::NOMBRE_TABLA . " where ". self::TOKEN ." = ?";
		    $sentencia = $pdo->prepare($comando);

	    	$sentencia->bindParam(1,$token);
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