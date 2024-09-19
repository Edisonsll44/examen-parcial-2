<?php
class ClubDto {
    public $id;
    public $nombre;
    public $deporte;
    public $ubicacion;
    public $fecha_fundacion;

    public function __construct($data) {
        $this->id = isset($data['club_id']) ? $data['club_id'] : null;
        $this->nombre = isset($data['nombre']) ? $data['nombre'] : '';
        $this->deporte = isset($data['deporte']) ? $data['deporte'] : '';
        $this->ubicacion = isset($data['ubicacion']) ? $data['ubicacion'] : '';
        $this->fecha_fundacion = isset($data['fecha_fundacion']) ? $data['fecha_fundacion'] : null;
    }
}
