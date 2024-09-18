<?php
class ClubDto {
    public $nombre;
    public $deporte;
    public $ubicacion;
    public $fecha_fundacion;

    public function __construct($data) {
        $this->nombre = $data['nombre'];
        $this->deporte = $data['deporte'];
        $this->ubicacion = $data['ubicacion'];
        $this->fecha_fundacion = $data['fecha_fundacion'];
    }
}
