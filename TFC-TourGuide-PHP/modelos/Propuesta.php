<?php

// Esta clase representa una Usuario

class Propuesta
{
    // Variables de clase
    private $idguia,$idanuncio ,$mensaje,$estado;

    // Constructor
    public function __construct($idguia,$idanuncio, $mensaje,$estado)
    {
        $this->idguia = $idguia;
        $this->idanuncio = $idanuncio;
        $this->mensaje = $mensaje;
        $this->estado = $estado;
    }

    public function getEstado(){
        return $this->estado;
    }

    public function getIdGuia(){
        return $this->idguia;
    }

    public function getIDAnuncio(){
        return $this->idanuncio;
    }

    public function getMensaje(){
        return $this->mensaje;
    }
    
    
    // Muestra los datos de la Usuario
    public function toString()
    {
        return
            [
                "idguia" => utf8_encode($this->idguia),
                "idanuncio" => utf8_encode($this->idanuncio),
                "mensaje" => utf8_encode($this->mensaje),
                "estado" => utf8_encode($this->estado)
            ];
    }
}