<?php
require_once '../../Model/Database.php';
require_once 'fpdf.php';

if (!isset($_GET['id'])) {
    die("ID de vente manquant");
}

$id_vente = $_GET['id'];
$db = new Database();

// 1. Récupérer les infos de la vente
$sql_vente = "SELECT v.*, c.nom as client_nom, c.prenom as client_prenom, u.nom as vendeur_nom 
              FROM vente v 
              LEFT JOIN client c ON v.id_client = c.id_client 
              LEFT JOIN users u ON v.id_user = u.id_user 
              WHERE v.id_vente = ?";
$rqt_vente = $db->requette($sql_vente, [$id_vente]);
$vente = $db->recupere($rqt_vente);

if (!$vente) {
    die("Vente introuvable");
}

// 2. Récupérer les détails
$sql_details = "SELECT dv.*, p.nom as produit_nom 
                FROM detail_vente dv 
                JOIN produit p ON dv.id_produit = p.id_produit 
                WHERE dv.id_vente = ?";
$rqt_details = $db->requette($sql_details, [$id_vente]);
$details = $db->recupere($rqt_details, false);

// 3. Génération du Ticket (Format Thermique 80mm large)
$pdf = new FPDF('P', 'mm', [80, 200]);
$pdf->SetMargins(5, 5, 5);
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

$pdf->Cell(0, 5, "G_STOCK", 0, 1, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(0, 5, "Ticket : #" . $vente->id_vente, 0, 1, 'C');
$pdf->Cell(0, 5, "Date : " . $vente->date, 0, 1, 'C');
$pdf->Ln(2);

$pdf->Line(5, $pdf->GetY(), 75, $pdf->GetY());
$pdf->Ln(2);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(35, 5, "Produit", 0);
$pdf->Cell(10, 5, "Qte", 0, 0, 'C');
$pdf->Cell(25, 5, "Total", 0, 1, 'R');
$pdf->SetFont('Arial', '', 8);

foreach ($details as $d) {
    $pdf->Cell(35, 5, substr(mb_convert_encoding($d->produit_nom, 'ISO-8859-1', 'UTF-8'), 0, 20), 0);
    $pdf->Cell(10, 5, $d->quantite, 0, 0, 'C');
    $pdf->Cell(25, 5, number_format($d->prix * $d->quantite, 0, '.', ' '), 0, 1, 'R');
}

$pdf->Ln(2);
$pdf->Line(5, $pdf->GetY(), 75, $pdf->GetY());
$pdf->Ln(2);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(45, 5, "TOTAL : ", 0);
$pdf->Cell(25, 5, number_format($vente->total, 0, '.', ' ') . " FCFA", 0, 1, 'R');

$pdf->Ln(5);
$pdf->SetFont('Arial', 'I', 7);
$pdf->Cell(0, 5, "Vendeur : " . $vente->vendeur_nom, 0, 1, 'C');
$pdf->Cell(0, 5, "Merci de votre visite !", 0, 1, 'C');

$pdf->Output('I', 'Ticket_' . $vente->id_vente . '.pdf');
