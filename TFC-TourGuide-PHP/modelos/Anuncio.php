<?php

// Esta clase representa una Usuario

class Anuncio{
    
    // Variables de clase
    private $idturista,$ciudad,$idtipo,$nombre,$acompanantes,$fechacreacion,$fecha1,$fecha2,$mensaje,$estado;

    // Constructor
    public function __construct($idturista,$ciudad,$idtipo,$nombre,$acompanantes,$fechacreacion,$fecha1,$fecha2,$mensaje,$estado)
    {
        $this->idturista = $idturista;
        $this->ciudad = $ciudad;
        $this->idtipo = $idtipo;
        $this->nombre = $nombre;
        $this->acompanantes = $acompanantes;
        $this->fechacreacion = $fechacreacion;
        $this->fecha1 = $fecha1;
        $this->fecha2 = $fecha2;
        $this->mensaje = $mensaje;
        $this->estado = $estado;
    }

    public function getEstado(){
        return $this->estado;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getIDTurista(){
        return $this->idturista;
    }

    public function getTipo(){
        return $this->idtipo;
    }

    public function getMensaje(){
        return $this->mensaje;
    }


    public function getFechaCreacion(){
        return $this->fechacreacion;
    }

    public function getCiudad(){
        return $this->ciudad;
    }

    public function getAcompanantes(){
        return $this->acompanantes;
    }
    
    public function getFecha1(){
        return $this->fecha1;
    }

    public function getFecha2(){
        return $this->fecha2;
    }

    // Muestra los datos de la Usuario
    public function toString()
    {
        return
            [
                "nombre" => utf8_encode($this->nombre),
                "ciudad" => utf8_encode($this->ciudad),
                "acompanante" => utf8_encode($this->acompanante),
                "fecha1" => utf8_encode($this->fecha1),
                "fecha2" => utf8_encode($this->fecha2)
            ];
    }
}