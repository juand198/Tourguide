<?php

require_once('datos/ConexionBD.php');
require_once('utilidades/ExcepcionApi.php');
require_once('datos/mensajes.php');
require_once('vistas/VistaJson.php');

// Esta clase representa un controlador para las personas
class ControladorMensajes
{
    // Nombdres de la tabla y de los atributos
    const NOMBRE_TABLA = "usuario";
    const usuario = "usuario";
    const contrasena = "contrasena";
    const token = "token";

    public function enviarMensajeDifusion($usuarioemisor,$titulomensaje,$mensaje)
    {
        try 
        {
        	$pdo = ConexionBD::obtenerInstancia()->obtenerBD();

            // Sentencia SELECT
            $comando = "SELECT token FROM " . self::NOMBRE_TABLA;
            //echo API_ACCESS_KEY;
            $sentencia = $pdo->prepare($comando);

            $sentencia->execute();

            $array = array();

            while ($row = $sentencia->fetch(PDO::FETCH_ASSOC)) 
            { 
                array_push($array, $row);
            }

            // Este código nos permite enviar un mensaje a un dispositivo Android concreto mediante el uso de FireBase
                        // Fuente: https://gist.github.com/MohammadaliMirhamed/7384b741a5c979eb13633dc6ea1269ce
                        // Autor: Francisco Jesús Delgado Almirón
                        // Clave del servidor, se encuentra en la configuración del proyecto en mensajería en la nube

                
                        // Me creo la vista para mostrar los mensajes

                //echo "La key es " . API_ACCESS_KEY;

                $vista = new VistaJson();
                         // Token del dispositivo al que vamos a enviar el mensaje
                        // En el caso de que haya más de un destinatario se separarán por comas
                $IDdestinatarios = ($array);
                // Preparo el mensaje
                $mensaje_a_enviar = array (
                'time_to_live' => 108,
                'body' => $mensaje,
                'title' => $titulomensaje,
                'vibrate' => 1,
                );

                // Datos extra en el mensaje que se envía con FireBase
                $datosmensaje = array (
                // envio contenido extra
                'emisor' => $usuarioemisor,
                'mensaje' => $mensaje,
                'titulo' => $titulomensaje
                );
                $mensajefinal = array (
                // En el campo to indicamos a quién le queremos enviar el mensaje
                // En el caso de poner el token de otro dispositivo lo enviará a ese dispositivo
                'to' => "/topics/todos",
                // En caso de querer enviar el mensaje a un topic (canal) habrá que poner /topics/nombrecanal
                // y lo enviará a todos los usuarios que estén subscritos a ese canal
                // 'to' => '/topics/nombrecanal',
                'notification' => $mensaje_a_enviar,
                'data' => $datosmensaje
                );
                $cabeceras = array (
                'Authorization: key=' . API_ACCESS_KEY,
                'Content-Type: application/json'
                );
                // Enviar el mensaje al servidor de FireBase
                 $ch = curl_init();
                 curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                 curl_setopt($ch, CURLOPT_POST, true);
                 curl_setopt($ch, CURLOPT_HTTPHEADER, $cabeceras);
                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                 curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($mensajefinal));
                 $resultado_mensaje = curl_exec($ch);
                 curl_close($ch);
                 # Muestro el resultado que me devuelve el servidor de FireBase
                //$vista->imprimir($resultado_mensaje);
                return [
                            [
                                "mensaje" => $resultado_mensaje
                            ]
                        ];
        }
        catch (PDOException $e) 
        {
            throw new ExcepcionApi(ESTADO_ERROR_BD, $e->getMessage());
        }
        

    } 


    public function enviarMensajeUsuario($usuarioemisor,$usuarioreceptor,$Mensaje)
    {
        try 
        {
            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

                    // Sentencia SELECT
            $comando = "SELECT token FROM " . self::NOMBRE_TABLA . " WHERE " . self::usuario ." = ?";

            $sentencia = $pdo->prepare($comando);

            $sentencia->bindParam(1, $usuarioreceptor);

            $sentencia->execute();

            $array = array();
            $tokenenviar = "";

            while ($row = $sentencia->fetch(PDO::FETCH_ASSOC)) 
            { 
                array_push($array, $row);
                $tokenenviar = $row['token'];
            }

            //echo "El token es " . $tokenenviar;

                    // Este código nos permite enviar un mensaje a un dispositivo Android concreto mediante el uso de FireBase
                    // Fuente: https://gist.github.com/MohammadaliMirhamed/7384b741a5c979eb13633dc6ea1269ce
                    // Autor: Francisco Jesús Delgado Almirón
                    // Clave del servidor, se encuentra en la configuración del proyecto en mensajería en la nube

            
                    // Me creo la vista para mostrar los mensajes
            $vista = new VistaJson();
                     // Token del dispositivo al que vamos a enviar el mensaje
                    // En el caso de que haya más de un destinatario se separarán por comas
            $IDdestinatarios = ($tokenenviar);
            // Preparo el mensaje
            $mensaje_a_enviar = array (
            'time_to_live' => 108,
            'body' => $Mensaje->getMensaje(),
            'title' => $Mensaje->getTitulo(),
            'vibrate' => 1,
            );

            // Datos extra en el mensaje que se envía con FireBase
            $datosmensaje = array (
                //Enviamos mensajes extra
            'emisor' => $usuarioemisor
            );
            $mensajefinal = array (
            // En el campo to indicamos a quién le queremos enviar el mensaje
            // En el caso de poner el token de otro dispositivo lo enviará a ese dispositivo
            'to' => $IDdestinatarios,
            // En caso de querer enviar el mensaje a un topic (canal) habrá que poner /topics/nombrecanal
            // y lo enviará a todos los usuarios que estén subscritos a ese canal
            // 'to' => '/topics/nombrecanal',
            'notification' => $mensaje_a_enviar,
            'data' => $datosmensaje
            );
            $cabeceras = array (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
            );
            // Enviar el mensaje al servidor de FireBase
             $ch = curl_init();
             curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
             curl_setopt($ch, CURLOPT_POST, true);
             curl_setopt($ch, CURLOPT_HTTPHEADER, $cabeceras);
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
             curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
             curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($mensajefinal));
             $resultado_mensaje = curl_exec($ch);
             curl_close($ch);
             # Muestro el resultado que me devuelve el servidor de FireBase
            //$vista->imprimir($resultado_mensaje);
            return [
                        [
                            "mensaje" => $resultado_mensaje
                        ]
                    ];
        }
        catch (PDOException $e) 
        {
            throw new ExcepcionApi(ESTADO_ERROR_BD, $e->getMessage());
        }
    }



}

?>