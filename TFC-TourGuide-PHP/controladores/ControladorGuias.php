<?php

require_once('datos/ConexionBD.php');
require_once('utilidades/ExcepcionApi.php');
require_once('datos/mensajes.php');

// Esta clase representa un controlador para los turistas
class ControladorGuias
{
    // Nombdres de la tabla y de los atributos
	const NOMBRE_TABLA = "guia";
	const ID = "ID";
    const NOMBRE = "Nombre";
    const APELLIDOS = "Apellidos";
    const EMAIL = "Email";
    const CIUDAD = "IDCiudad";
    const PROVINCIA = "IDProvincia";
    const TOKEN = "Token";
    const PUNTUACION = "puntuacion";

    /**
	 * Descripción: Inserta un guia en la base de datos
	 * @param guia guia para insertar en la base de datos
	 * @return Indica si se ha insertado el guia correctamente (Código 1)
	 */
    public function registrarGuia($guia)
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
                                                            ".self::PUNTUACION.",
                                                            ".self::PROVINCIA."
                                                            ) 
                            VALUES (
                            ?,
                            (SELECT ID FROM ciudades WHERE nombre = ?),
                            ?,
                            ?,
                            ?,
                            ?,
                            (Select ID FROM provincias WHERE nombre = ?)
                            )";

            $sentencia = $pdo->prepare($comando);
            // Pongo los datos en la consulta INSERT
            $sentencia->bindValue(1, $guia->getToken(),PDO::PARAM_STR);
            $sentencia->bindValue(2, $guia->getCiudad(),PDO::PARAM_STR);
            $sentencia->bindValue(3, $guia->getNombre(),PDO::PARAM_STR);
            $sentencia->bindValue(4, $guia->getApellidos(),PDO::PARAM_STR);
            $sentencia->bindValue(5, $guia->getEmail(),PDO::PARAM_STR);
            $sentencia->bindValue(6, $guia->getPuntuacion(),PDO::PARAM_STR);
            $sentencia->bindValue(7, $guia->getProvincia(),PDO::PARAM_STR);
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
     * Descripción: Elimina un guia en la base de datos
     * @param guia guia para eliminar en la base de datos
     * @return Indica si se ha eliminado el turista correctamente (Código 1)
     */
    public function eliminarGuia($guia)
    {
        try 
        {
            // Obtengo una instancia de la base de datos ya conectada
            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

            // Creo la sentencia INSERT
            $comando = "DELETE FROM ".self::NOMBRE_TABLA . " WHERE ".self::TOKEN." = ?";

            $sentencia = $pdo->prepare($comando);

            // Pongo los datos en la consulta INSERT
            $sentencia->bindValue(1, $guia);

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
     * Descripcion obtiene un guia en funcion de su id
     * @param IDguia  id del turista a buscar
     * @return JSON que indica si se ha obtenido  el usuario correctamente (Código 1)
     */
    public function obtenerGuia($IDguia)
    {
		try 
		{
		    $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

		    $comando = "SELECT g.".self::ID.", g.".self::NOMBRE.",g.foto as foto, g.".self::APELLIDOS.", g.".self::EMAIL.", g.".self::PUNTUACION.", c.nombre as ciudad , p.nombre as nombreProvincia
                        FROM ".self::NOMBRE_TABLA." g 
                        INNER JOIN ciudades c on g.".self::CIUDAD." = c.".self::ID." 
                        INNER JOIN provincias p on g.IDPROVINCIA = p.ID
                        WHERE g.".self::TOKEN." = ?";
		    $sentencia = $pdo->prepare($comando);

	    	$sentencia->bindParam(1,$IDguia);
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
     * obtiene todos
     * @param IDguia  id del turista a buscar
     * @return JSON que indica si se ha obtenido  el usuario correctamente (Código 1)
     */
    public function obtenerGuias()
    {
		try 
		{
		    $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

		    $comando = "SELECT g.".self::ID.",g.".self::TOKEN.", g.".self::NOMBRE.",g.foto as foto, g.".self::APELLIDOS.", g.".self::EMAIL.", g.".self::PUNTUACION.", c.nombre as ciudad , p.nombre as nombreProvincia
                        FROM ".self::NOMBRE_TABLA." g 
                        INNER JOIN ciudades c on g.".self::CIUDAD." = c.".self::ID." 
                        INNER JOIN provincias p on g.IDPROVINCIA = p.ID";
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
     * Descripcion obtiene un guia en funcion de su nombre
     * @param nombre  id del turista a buscar
     * @return JSON que indica si se ha obtenido  el usuario correctamente (Código 1)
     */
    public function obtenerGuiaNombre($nombre)
    {
		try 
		{
		    $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

		    $comando = "SELECT g.".self::ID.",g.".self::TOKEN." ,g.".self::NOMBRE.", g.".self::APELLIDOS.", g.".self::EMAIL.", g.".self::PUNTUACION.",g.foto as foto, c.nombre as ciudad , p.nombre as nombreProvincia
                        FROM ".self::NOMBRE_TABLA." g 
                        INNER JOIN ciudades c on g.".self::CIUDAD." = c.".self::ID." 
                        INNER JOIN provincias p on g.IDPROVINCIA = p.ID
                        WHERE g.".self::NOMBRE." = ?";
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


    /**
     * Descripcion obtiene un guia en funcion de su id
     * @param IDguia  id del turista a buscar
     * @return JSON que indica si se ha obtenido  el usuario correctamente (Código 1)
     */
    public function obtenerGuiaID($IDguia)
    {
		try 
		{
		    $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

		    $comando = "SELECT g.".self::ID.",g.".self::TOKEN." ,g.".self::NOMBRE.", g.".self::APELLIDOS.", g.".self::EMAIL.", g.".self::PUNTUACION.",g.foto as foto, c.nombre as ciudad , p.nombre as nombreProvincia
                        FROM ".self::NOMBRE_TABLA." g 
                        INNER JOIN ciudades c on g.".self::CIUDAD." = c.".self::ID." 
                        INNER JOIN provincias p on g.IDPROVINCIA = p.ID
                        WHERE g.".self::ID." = ?";
		    $sentencia = $pdo->prepare($comando);

	    	$sentencia->bindParam(1,$IDguia);
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