<?php

// Esta clase representa una Usuario

class Turista
{
    // Variables de clase
    private $id,$token ,$nombre, $apellidos,$ciudad,$email,$puntuacion;

    // Constructor
    public function __construct($token,$nombre, $apellidos,$ciudad,$email,$puntuacion)
    {
        $this->token = $token;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->ciudad = $ciudad;
        $this->email = $email;
        $this->puntuacion = $puntuacion;
    }

    public function getToken(){
        return $this->token;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getApellidos(){
        return $this->apellidos;
    }
    
    public function getCiudad(){
        return $this->ciudad;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPuntuacion(){
        return $this->puntuacion;
    }

    // Muestra los datos de la Usuario
    public function toString()
    {
        return
            [
                "id" => utf8_encode($this->id),
                "nombre" => utf8_encode($this->nombre),
                "apellido1" => utf8_encode($this->getApellidos),
                "email" => utf8_encode($this->email),
                "puntuacion" => utf8_encode($this->puntuacion),
                "token" => utf8_encode($this->token),
            ];
    }
}