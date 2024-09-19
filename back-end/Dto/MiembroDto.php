<?php
class MiembroDto {
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $club_id;

    public function __construct($data) {
        $this->id = $data['miembro_id'] ?? null;
        $this->nombre = $data['nombre'] ?? null;
        $this->apellido = $data['apellido'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->telefono = $data['telefono'] ?? null;
        $this->club_id = $data['club_id'] ?? null;
    }
}
