<?php
session_start(); // Pour éviter erreurs SESSIONS
ob_start(); // Pour éviter erreur COOKIES


require_once 'configs/chemins.class.php';
require_once Chemins::CONFIGS . 'mysql_config.class.php';
require_once Chemins::MODELES . 'gestionBoutique.class.php';
require_once Chemins::MODELES . 'gestionClient.class.php';
require_once Chemins::MODELES . 'gestionProduit.class.php';
require_once Chemins::MODELES . 'gestionMarque.class.php';
require_once Chemins::MODELES . 'gestionCommande.class.php';
require_once Chemins::MODELES . 'gestionCategorie.class.php';
require_once Chemins::MODELES . 'Panier.class.php';




require_once Chemins::CONFIGS . 'variables_globales.class.php';

// Vérifiez si l'affichage complet est demandé
$displayHeaderFooter = !isset($_REQUEST['display']) || $_REQUEST['display'] !== 'minimal';

if ($displayHeaderFooter) {
    require Chemins::VUES_PERMANENTES . 'v_entete.inc.php';
}

if (!isset($_REQUEST['controleur'])) {
    require_once(Chemins::VUES . "v_accueil.inc.php");
    
} else {
    $classeControleur = 'controleur' . $_REQUEST['controleur']; //ex : ControleurProduits
    $fichierControleur = $classeControleur . ".class.php"; //ex : ControleurProduits.class.php
    require_once(Chemins::CONTROLEURS . $fichierControleur);

    $action = $_REQUEST['action']; //exemple : afficher

    $objetControleur = new $classeControleur(); //ex : $objetControleur = new ControleurProduits();
    $objetControleur->$action(); //ex : $objetControleur->afficher();
    //version avec classe statique
    // $classeStatiqueControleur = 'Controleur' . $_REQUEST['controleur'];
    // $classeStatiqueControleur::$action();
    // Fonction pour stocker les filtres dans les cookies
}

if ($displayHeaderFooter) {
    require Chemins::VUES_PERMANENTES . 'v_piedPage.inc.php';
}

?>
