<?php
class MiembroDto {
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $club_id;
    public $club;

    public function __construct($data) {
        $this->id = $data['miembro_id'] ?? null;
        $this->nombre = $data['miembro_nombre'] ?? null;
        $this->apellido = $data['miembro_apellido'] ?? null;
        $this->email = $data['miembro_email'] ?? null;
        $this->telefono = $data['miembro_telefono'] ?? null;
        $this->club_id = $data['club_id'] ?? null;
        $this->club = $data['club_nombre'] ?? null;
    }
}
