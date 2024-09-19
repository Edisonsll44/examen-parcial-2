<?php
require_once '../libs/fpdf.php';

require_once '../config/MiembrosRepository.php';
require_once '../config/database.php';

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Reporte de Miembros', 0, 1, 'C');
        $this->Ln(10);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(20, 10, 'ID', 1);
        $this->Cell(40, 10, 'Nombre', 1);
        $this->Cell(40, 10, 'Apellido', 1);
        $this->Cell(40, 10, 'Email', 1);
        $this->Cell(30, 10, 'Teléfono', 1);
        $this->Cell(30, 10, 'Club', 1);
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
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

foreach ($miembros as $miembro) {
    $pdf->Cell(20, 10, $miembro['miembro_id'], 1);
    $pdf->Cell(40, 10, $miembro['miembro_nombre'], 1);
    $pdf->Cell(40, 10, $miembro['miembro_apellido'], 1);
    $pdf->Cell(40, 10, $miembro['miembro_email'], 1);
    $pdf->Cell(30, 10, $miembro['miembro_telefono'], 1);
    $pdf->Cell(30, 10, $miembro['club_nombre'], 1);
    $pdf->Ln();
}

$pdf->Output('D', 'reporte_miembros.pdf');