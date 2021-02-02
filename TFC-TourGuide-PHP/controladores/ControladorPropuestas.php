<?php
require_once('datos/ConexionBD.php');
require_once('utilidades/ExcepcionApi.php');
require_once('datos/mensajes.php');

// Esta clase representa un controlador para los turistas
class ControladorPropuestas{

    // Nombdres de la tabla y de los atributos
	const NOMBRE_TABLA = "propuesta";
	const ID = "ID";
    const IDGUIA = "IDGuia";
	const IDANUNCIO = "IDAnuncio";
	const MENSAJE = "Mensaje";
	const ESTADO = "Estado";

    /**
     * Descripcion obtiene todas las ciudades
     * @return JSON con todas las ciudades
     */
    public function obtenerPropuestasIDAIDGuia($idAnuncio,$idGuia)
    {
		try 
		{
		    $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

		    $comando = "SELECT * FROM ".self::NOMBRE_TABLA." 
                        WHERE ".self::IDANUNCIO." = (Select ID from anuncios Where ID = ?) 
                        AND ".self::IDGUIA." = (SELECT ID FROM guia WHERE ID = ?)";

			$sentencia = $pdo->prepare($comando);
			
			$sentencia->bindValue(1, $idAnuncio);
            $sentencia->bindValue(2, $idGuia);
            
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
    public function obtenerPropuestasIDA($idAnuncio)
    {
		try 
		{
		    $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

		    $comando = "SELECT * FROM " . self::NOMBRE_TABLA . " WHERE ".self::IDANUNCIO." = (Select ".self::ID." from anuncios Where ".self::ID." = ?)";
			$sentencia = $pdo->prepare($comando);
			
			$sentencia->bindValue(1, $idAnuncio);
			
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
    public function obtenerPropuestasIDGuia($idGuia)
    {
		try 
		{
		    $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

		    $comando = "SELECT p.* FROM ".self::NOMBRE_TABLA." p INNER JOIN guia g on g.ID = p.".self::IDGUIA." WHERE g.ID  = ?";
			$sentencia = $pdo->prepare($comando);
			
			$sentencia->bindValue(1, $idGuia);
			
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
    public function obtenerPropuestasID($id)
    {
		try 
		{
		    $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

		    $comando = "SELECT * FROM ".self::NOMBRE_TABLA." WHERE ".self::ID." = ?";
			$sentencia = $pdo->prepare($comando);
			
			$sentencia->bindValue(1, $id);
			
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
    public function obtenerPropuestas()
    {
		try 
		{
		    $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

		    $comando = "SELECT * FROM ".self::NOMBRE_TABLA ;
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
	public function registrarPropuesta($propuesta)
    {
        try 
        {
            // Obtengo una instancia de la base de datos ya conectada
            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

            // Creo la sentencia INSERT
            $comando = "INSERT INTO ".self::NOMBRE_TABLA."(
                                                            ".self::IDGUIA.", 
                                                            ".self::IDANUNCIO.", 
                                                            ".self::MENSAJE.",
                                                            ".self::ESTADO."
                                                            ) 
                            VALUES (
                            ?,
                            ?,
                            ?,
                            ?
                            )";

            $sentencia = $pdo->prepare($comando);
            // Pongo los datos en la consulta INSERT
            $sentencia->bindValue(1, $propuesta->getIDGuia(),PDO::PARAM_STR);
            $sentencia->bindValue(2, $propuesta->getIDAnuncio(),PDO::PARAM_STR);
            $sentencia->bindValue(3, $propuesta->getMensaje(),PDO::PARAM_STR);
            $sentencia->bindValue(4, $propuesta->getEstado(),PDO::PARAM_STR);
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
    public function eliminarpropuestaid($id)
    {
        try 
        {
            // Obtengo una instancia de la base de datos ya conectada
            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

            // Creo la sentencia INSERT
            $comando = "DELETE FROM ".self::NOMBRE_TABLA." WHERE ID = ?";

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
    public function cambiarEstadoPropuesta($estado,$idPropuesta)
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
            $sentencia->bindValue(2, $idPropuesta);
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

}