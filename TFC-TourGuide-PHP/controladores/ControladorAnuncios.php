<?php

require_once('datos/ConexionBD.php');
require_once('utilidades/ExcepcionApi.php');
require_once('datos/mensajes.php');
// Esta clase representa un controlador para los turistas
class ControladorAnuncios
{
    
    // Nombdres de la tabla y de los atributos
	const NOMBRE_TABLA = "anuncios";
	const ID = "ID";
    const TURISTA = "IDTurista";    
    const CIUDAD = "IDCiudad";
    const IDGUIA = "IDGuia";
    const TIPO = "IDTipo";
    const NOMBRE_VIAJE = "NombreViaje";
    const ACOMPANANTES = "Acompanantes";
    const FECHACREACION = "FechaCreacion";
    const FECHAINICIO = "FechaInicio";
    const FECHAFIN = "FechaFin";
    const MENSAJE = "Mensaje";
    const ESTADO = "Estado";

    /**
	 * Descripción: Inserta un guia en la base de datos
	 * @param guia guia para insertar en la base de datos
	 * @return Indica si se ha insertado el guia correctamente (Código 1)
	 */
    public function publicarAnuncio($anuncio)
    {
        try 
        {
            // Obtengo una instancia de la base de datos ya conectada
            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

            // Creo la sentencia INSERT
            $comando = "INSERT INTO ".self::NOMBRE_TABLA."(".self::TURISTA.", 
                                                            ".self::CIUDAD.", 
                                                            ".self::TIPO.", 
                                                            ".self::NOMBRE_VIAJE.", 
                                                            ".self::ACOMPANANTES.", 
                                                            ".self::FECHACREACION.", 
                                                            ".self::FECHAINICIO.",
                                                            ".self::FECHAFIN.",
                                                            ".self::MENSAJE.",
                                                            ".self::ESTADO."
                                                        ) 
                            VALUES (
                            (SELECT ".self::ID." FROM Turista WHERE Token = ?),
                            (SELECT ".self::ID." FROM ciudades WHERE nombre = ?),
                            (SELECT ".self::ID." FROM tipo WHERE Nombre = ?),
                            ?,
                            ?,
                            ?,
                            ?,
                            ?,
                            ?,
                            ?
                            )";

            $sentencia = $pdo->prepare($comando);
            // Pongo los datos en la consulta INSERT
            $sentencia->bindValue(1, $anuncio->getIDTurista(),PDO::PARAM_STR);
            $sentencia->bindValue(2, $anuncio->getCiudad(),PDO::PARAM_STR);
            $sentencia->bindValue(3, $anuncio->getTipo(),PDO::PARAM_STR);
            $sentencia->bindValue(4, $anuncio->getNombre(),PDO::PARAM_STR);
            $sentencia->bindValue(5, $anuncio->getAcompanantes(),PDO::PARAM_STR);
            $sentencia->bindValue(6, $anuncio->getFechaCreacion(),PDO::PARAM_STR);
            $sentencia->bindValue(7, $anuncio->getFecha1(),PDO::PARAM_STR);
            $sentencia->bindValue(8, $anuncio->getFecha2(),PDO::PARAM_STR);
            $sentencia->bindValue(9, $anuncio->getMensaje(),PDO::PARAM_STR);
            $sentencia->bindValue(10, $anuncio->getEstado(),PDO::PARAM_STR);
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
     * Descripción: Elimina un anuncio en la base de datos
     * @param id id para eliminar en la base de datos
     * @return Indica si se ha eliminado el turista correctamente (Código 1)
     */
    public function eliminarAnuncio($id)
    {
        try 
        {
            // Obtengo una instancia de la base de datos ya conectada
            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

            // Creo la sentencia INSERT
            $comando = "DELETE FROM ".self::NOMBRE_TABLA . " WHERE ".self::ID." = ?";

            $sentencia = $pdo->prepare($comando);

            // Pongo los datos en la consulta INSERT
            $sentencia->bindValue(1, $id);

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
     * 
     */
    public function cambiarEstadoAnuncio($estado,$idanuncio)
    {
        try 
        {
            // Obtengo una instancia de la base de datos ya conectada
            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

            // Creo la sentencia INSERT
            $comando = "UPDATE ".self::NOMBRE_TABLA." SET ".self::ESTADO."= ? WHERE ".self::ID." = ?";

            $sentencia = $pdo->prepare($comando);

            // Pongo los datos en la consulta INSERT
            $sentencia->bindValue(1, $estado);
            $sentencia->bindValue(2, $idanuncio);

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
     * 
     */
    public function cambiarIDGuiaAnuncio($idguia,$idanuncio)
    {
        try 
        {
            // Obtengo una instancia de la base de datos ya conectada
            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

            // Creo la sentencia INSERT
            $comando = "UPDATE ".self::NOMBRE_TABLA." SET ".self::IDGUIA."= ? WHERE ".self::ID." = ?";

            $sentencia = $pdo->prepare($comando);

            // Pongo los datos en la consulta INSERT
            $sentencia->bindValue(1, $idguia);
            $sentencia->bindValue(2, $idanuncio);

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
     * Descripcion obtiene todos los anuncios de un usuario
     * @param usuario
     * @return JSON que indica si se ha obtenido  el usuario correctamente (Código 1)
     */
    public function obtenerAnuncios($usuario)
    {
		try 
		{
		    $pdo = ConexionBD::obtenerInstancia()->obtenerBD();
		    $comando = "SELECT a.Estado as Estado, a.ID,a.NombreViaje,a.Acompanantes,CAST(a.FechaCreacion AS DATE) as FechaCreacion,CAST(a.FechaInicio AS DATE) as FechaInicio,CAST(a.FechaFin AS DATE) as FechaFin,a.Mensaje,c.nombre as nombreCiudad,t.Nombre as nombreInteres
                        FROM ".self::NOMBRE_TABLA." a 
                        INNER JOIN ciudades c on a.".self::CIUDAD." = c.".self::ID." 
                        INNER JOIN tipo t on a.IDTipo = t.".self::ID." 
                        INNER JOIN turista tur on a.IDTurista = tur.".self::ID." WHERE tur.Token = ?";
            $sentencia = $pdo->prepare($comando);
            $sentencia->bindParam(1,$usuario);
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
    public function obtenerAnunciosCiudad($ciudad)
    {
		try 
		{
		    $pdo = ConexionBD::obtenerInstancia()->obtenerBD();
		    $comando = "SELECT a.*,c.ID as idCiudad,c.nombre as ciudad,p.foto as fotoprovincia, p.nombre as nombreprovincia, t.Token as token ,ti.Nombre as interes
                        FROM ".self::NOMBRE_TABLA." a 
                        INNER JOIN ciudades c on c.ID = a.IDCiudad 
                        INNER JOIN provincias p on p.ID = c.IDProvincia 
                        INNER JOIN turista t on t.ID = a.IDTurista 
                        INNER JOIN tipo ti on ti.ID = a.IDTipo
                        WHERE p.nombre = ?";

            $sentencia = $pdo->prepare($comando);
            $sentencia->bindParam(1,$ciudad);
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
    public function obtenerAnunciosIDAnuncio($id)
    {
		try 
		{
		    $pdo = ConexionBD::obtenerInstancia()->obtenerBD();
		    $comando = "SELECT a.*,c.ID as idCiudad,c.nombre as ciudad,p.foto as fotoprovincia, p.nombre as nombreprovincia, t.Token as tokenturista ,ti.Nombre as interes
                        FROM ".self::NOMBRE_TABLA." a 
                        INNER JOIN ciudades c on c.ID = a.IDCiudad 
                        INNER JOIN provincias p on p.ID = c.IDProvincia 
                        INNER JOIN turista t on t.ID = a.IDTurista 
                        INNER JOIN tipo ti on ti.ID = a.IDTipo
                        WHERE a.".self::ID." = ?";

            $sentencia = $pdo->prepare($comando);
            $sentencia->bindParam(1,$id);
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
    public function obtenerAnunciosIDGuia($idguia)
    {
		try 
		{
		    $pdo = ConexionBD::obtenerInstancia()->obtenerBD();
		    $comando = "SELECT a.*,c.ID as idCiudad,c.nombre as ciudad,p.foto as fotoprovincia, p.nombre as nombreprovincia, t.Token as tokenturista ,ti.Nombre as interes
                        FROM ".self::NOMBRE_TABLA." a 
                        INNER JOIN ciudades c on c.ID = a.IDCiudad 
                        INNER JOIN provincias p on p.ID = c.IDProvincia 
                        INNER JOIN turista t on t.ID = a.IDTurista 
                        INNER JOIN tipo ti on ti.ID = a.IDTipo
                        WHERE a.".self::IDGUIA." = ?";

            $sentencia = $pdo->prepare($comando);
            $sentencia->bindParam(1,$idguia);
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
     * Descripcion obtiene todos los anuncios de un usuario
     * @param usuario
     * @return JSON que indica si se ha obtenido  el usuario correctamente (Código 1)
     */
    public function obtenerTodosAnuncios()
    {
		try 
		{
		    $pdo = ConexionBD::obtenerInstancia()->obtenerBD();
		    $comando = "SELECT a.Estado as Estado, a.ID,a.NombreViaje,a.Acompanantes,CAST(a.FechaCreacion AS DATE) as FechaCreacion,CAST(a.FechaInicio AS DATE) as FechaInicio,CAST(a.FechaFin AS DATE) as FechaFin,a.Mensaje,c.nombre as nombreCiudad,t.Nombre as nombreInteres
                        FROM ".self::NOMBRE_TABLA." a 
                        INNER JOIN ciudades c on a.".self::CIUDAD." = c.".self::ID." 
                        INNER JOIN tipo t on a.IDTipo = t.".self::ID." 
                        INNER JOIN turista tur on a.IDTurista = tur.".self::ID;
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