<?php
require_once '../libs/fpdf.php';
require_once '../config/MiembrosRepository.php';
require_once '../config/database.php';

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Reporte de Miembros', 0, 1, 'C');
        $this->Ln(5);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'Fecha y Hora: ' . date('d/m/Y H:i:s'), 0, 1, 'C');
        $this->Ln(10);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(20, 10, 'ID', 1);
        $this->Cell(40, 10, 'Nombre', 1);
        $this->Cell(40, 10, 'Apellido', 1);
        $this->Cell(70, 10, 'Email', 1);
        $this->Cell(30, 10, 'Teléfono', 1);
        $this->Cell(70, 10, 'Club', 1);
        $this->Ln();
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página '.$this->PageNo(), 0, 0, 'C');
    }
}

$database = new Database();
$db = $database->getConnection();
$miembroRepository = new MiembroRepository($db);
$miembros = $miembroRepository->findAll();

$pdf = new PDF();
$pdf->AddPage('L'); 
$pdf->SetFont('Arial', '', 10);

if (empty($miembros)) {
    $pdf->Cell(0, 10, 'No hay miembros disponibles.', 1, 1, 'C');
} else {
    foreach ($miembros as $miembro) {
        $pdf->Cell(20, 10, $miembro['miembro_id'], 1);
        $pdf->Cell(40, 10, $miembro['miembro_nombre'], 1);
        $pdf->Cell(40, 10, $miembro['miembro_apellido'], 1);
        $pdf->Cell(70, 10, $miembro['miembro_email'], 1);
        $pdf->Cell(30, 10, $miembro['miembro_telefono'], 1);
        $pdf->Cell(70, 10, $miembro['club_nombre'], 1);
        $pdf->Ln();
    }
}

$fechaHora = date('Ymd_His'); // Formato: YYYYMMDD_HHMMSS
$nombreArchivo = "miembros_equipo_$fechaHora.pdf";
$pdf->Output('D', $nombreArchivo);
