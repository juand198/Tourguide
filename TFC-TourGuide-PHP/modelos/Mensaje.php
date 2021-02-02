<?php

// Esta clase representa un mensaje

class mensaje
{
    // Variables de clase
    private $mensaje, $emisor, $receptor;

    // Constructor
    public function __construct($ntitulo, $nmensaje)
    {
        $this->mensaje = $nmensaje;
    }

    public function getMensaje()
    {
        return $this->mensaje;
    }    

    // Muestra los datos de la persona
    public function toString()
    {
        return
            [
                "mensaje" => utf8_encode($this->mensaje),
            ];
    }
}