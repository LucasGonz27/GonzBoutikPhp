<?php
// Démarrer la session si ce n'est pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Empêcher l'affichage des erreurs
error_reporting(0);
ini_set('display_errors', 0);

require_once Chemins::MODELES . 'gestionCommande.class.php';
require_once Chemins::MODELES . 'gestionClient.class.php';
require_once Chemins::MODELES . 'gestionProduit.class.php';
require_once Chemins::CONFIGS . 'tcpdf/tcpdf.php';

class ControleurCommande {
    
    public function telechargerFacture() {
        if (isset($_GET['idCommande'])) {
            $idCommande = $_GET['idCommande'];
            
            // Récupérer les informations de la commande
            $commande = GestionCommande::getCommandeById($idCommande);
            $lignesCommande = GestionCommande::getLignesDeCommande($idCommande);
            $client = GestionClient::getClientParEmail($_SESSION['login_client']);
            var_dump($client); // Pour débogage
            
            // Créer un nouveau document PDF
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            
            // Définir les informations du document
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('GonzBoutik');
            $pdf->SetTitle('Facture #' . $idCommande);
            
            // Supprimer les en-têtes et pieds de page par défaut
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            
            // Définir les marges
            $pdf->SetMargins(15, 15, 15);
            
            // Ajouter une page
            $pdf->AddPage();
            
            // Définir la police
            $pdf->SetFont('helvetica', '', 10);
            
            // Ajouter le logo
            $pdf->Image(Chemins::IMAGES . 'Logo.png', 15, 15,  40);
            
            // Informations de l'entreprise
            $pdf->SetXY(120, 15);
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(0, 10, 'GonzBoutik', 0, 1, 'R');
            $pdf->SetFont('helvetica', '', 10);
            $pdf->SetXY(120, 25);
            $pdf->Cell(0, 10, '2 chemin du rec d Estric', 0, 1, 'R');
            $pdf->SetXY(120, 35);
            $pdf->Cell(0, 10, '11200 Névian', 0, 1, 'R');
            $pdf->SetXY(120, 45);
            $pdf->Cell(0, 10, 'Tél: 06 23 59 60 45', 0, 1, 'R');
            
            // Titre de la facture
            $pdf->SetXY(15, 70);
            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->Cell(0, 10, 'FACTURE', 0, 1, 'L');
            
            // Numéro de facture et date
            $pdf->SetXY(15, 85);
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(0, 10, 'Facture N°: ' . $idCommande, 0, 1, 'L');
            $pdf->SetXY(15, 95);
            $pdf->Cell(0, 10, 'Date: ' . date('d/m/Y', strtotime($commande->date)), 0, 1, 'L');
            
            // Informations du client
            $pdf->SetXY(15, 115);
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(0, 10, 'Client:', 0, 1, 'L');
            $pdf->SetFont('helvetica', '', 10);
            $pdf->SetXY(15, 125);
            $pdf->Cell(0, 10, $client->nom . ' ' . $client->prenom, 0, 1, 'L');
            $pdf->SetXY(15, 135);
            $pdf->Cell(0, 10, $client->rue, 0, 1, 'L');
            $pdf->SetXY(15, 145);
            $pdf->Cell(0, 10, $client->codePostal . ' ' . $client->ville, 0, 1, 'L');
            
            // En-tête du tableau
            $pdf->SetXY(15, 165);
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(80, 10, 'Produit', 1, 0, 'C');
            $pdf->Cell(20, 10, 'Quantité', 1, 0, 'C');
            $pdf->Cell(30, 10, 'Prix unitaire', 1, 0, 'C');
            $pdf->Cell(30, 10, 'Total', 1, 1, 'C');
            
            // Contenu du tableau
            $pdf->SetFont('helvetica', '', 10);
            $y = 175;
            foreach ($lignesCommande as $ligne) {
                $produit = GestionProduit::getProduitById($ligne->idProduit);
                $pdf->SetXY(15, $y);
                $pdf->Cell(80, 10, $produit->nom, 1, 0, 'L');
                $pdf->Cell(20, 10, $ligne->quantite, 1, 0, 'C');
                $pdf->Cell(30, 10, number_format($ligne->prixUnitaire, 2, ',', ' ') . ' €', 1, 0, 'R');
                $pdf->Cell(30, 10, number_format($ligne->sousTotal, 2, ',', ' ') . ' €', 1, 1, 'R');
                $y += 10;
            }
            
            // Total
            $pdf->SetXY(15, $y);
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(130, 10, 'Total', 1, 0, 'R');
            $pdf->Cell(30, 10, number_format($commande->total, 2, ',', ' ') . ' €', 1, 1, 'R');
            
            // Pied de page
            $pdf->SetXY(15, $y + 20);
            $pdf->SetFont('helvetica', 'I', 8);
            $pdf->Cell(0, 10, 'Merci de votre confiance !', 0, 1, 'C');
            
            // Nettoyer la sortie
            ob_clean();
            
            // En-têtes pour le téléchargement
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="facture_' . $idCommande . '.pdf"');
            header('Cache-Control: no-cache, must-revalidate');
            header('Pragma: no-cache');
            
            // Envoyer le PDF
            $pdf->Output('facture_' . $idCommande . '.pdf', 'D');
            exit();
        }
    }
} 