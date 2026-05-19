<?php
require_once '../../Model/Database.php';
require_once 'fpdf.php';

if (!isset($_GET['id'])) {
    die("ID de vente manquant");
}

$id_vente = $_GET['id'];
$db = new Database();

// 1. Récupérer les infos de la vente et du client
$sql_vente = "SELECT v.*, c.nom as client_nom, c.prenom as client_prenom, c.adresse, c.telephone, u.nom as vendeur_nom 
              FROM vente v 
              LEFT JOIN client c ON v.id_client = c.id_client 
              LEFT JOIN users u ON v.id_user = u.id_user 
              WHERE v.id_vente = ?";
$rqt_vente = $db->requette($sql_vente, [$id_vente]);
$vente = $db->recupere($rqt_vente);

if (!$vente) {
    die("Vente introuvable");
}

// 2. Récupérer les détails de la vente
$sql_details = "SELECT dv.*, p.nom as produit_nom 
                FROM detail_vente dv 
                JOIN produit p ON dv.id_produit = p.id_produit 
                WHERE dv.id_vente = ?";
$rqt_details = $db->requette($sql_details, [$id_vente]);
$details = $db->recupere($rqt_details, false);

// 3. Génération du PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// En-tête
$pdf->Cell(0, 10, mb_convert_encoding("FACTURE G_STOCK", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 10, mb_convert_encoding("Date : " . $vente->date, 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');
$pdf->Cell(0, 5, mb_convert_encoding("Facture N° : #" . $vente->id_vente, 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');

$pdf->Ln(10);

// Infos Client
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, mb_convert_encoding("Client :", 'ISO-8859-1', 'UTF-8'), 0, 1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 5, mb_convert_encoding(($vente->client_prenom ?? '') . " " . ($vente->client_nom ?? 'Passager'), 'ISO-8859-1', 'UTF-8'), 0, 1);
$pdf->Cell(0, 5, mb_convert_encoding("Contact : " . ($vente->telephone ?? 'N/A'), 'ISO-8859-1', 'UTF-8'), 0, 1);
$pdf->Cell(0, 5, mb_convert_encoding("Adresse : " . ($vente->adresse ?? 'N/A'), 'ISO-8859-1', 'UTF-8'), 0, 1);

$pdf->Ln(10);

// Tableau des produits
$pdf->SetFillColor(230, 230, 230);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(90, 8, "Produit", 1, 0, 'C', true);
$pdf->Cell(30, 8, mb_convert_encoding("Prix Unit.", 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
$pdf->Cell(30, 8, mb_convert_encoding("Qté", 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
$pdf->Cell(40, 8, "Total", 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);
foreach ($details as $d) {
    $pdf->Cell(90, 8, mb_convert_encoding($d->produit_nom, 'ISO-8859-1', 'UTF-8'), 1);
    $pdf->Cell(30, 8, number_format($d->prix, 0, '.', ' ') . " FCFA", 1, 0, 'R');
    $pdf->Cell(30, 8, $d->quantite, 1, 0, 'C');
    $pdf->Cell(40, 8, number_format($d->prix * $d->quantite, 0, '.', ' ') . " FCFA", 1, 1, 'R');
}

// Total
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(150, 10, "TOTAL GENERAL : ", 0, 0, 'R');
$pdf->Cell(40, 10, number_format($vente->total, 0, '.', ' ') . " FCFA", 1, 1, 'R');

$pdf->Ln(20);
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0, 5, mb_convert_encoding("Vendeur : " . $vente->vendeur_nom, 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');
$pdf->Cell(0, 5, mb_convert_encoding("Merci de votre confiance !", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

$pdf->Output('I', 'Facture_' . $vente->id_vente . '.pdf');
