<?php

require_once Chemins::MODELES . 'Panier.class.php';

class ControleurProduits {
    public function __construct() {
        // Constructeur du contrôleur
    }
 
        public function afficher() {
            $lesProduits = [];
            $marqueSelectionnee = '';
    
            // Filtrage des produits
            if (isset($_REQUEST['marque'])) {
                $marqueSelectionnee = $_REQUEST['marque']; // Récupère la marque
                $lesProduits = GestionProduit::getProduitsParMarque($marqueSelectionnee); // Récupère les produits de cette marque
            }
    
            // Enregistrement des produits et de la marque dans la variable globale
            VariablesGlobales::$lesProduits = $lesProduits;
            VariablesGlobales::$marqueSelectionnee = $marqueSelectionnee; // Transmettre la marque à la vue
    
            // Inclusion de la vue pour afficher les produits
            require Chemins::VUES . 'v_produits.inc.php';
        }
    
    

    
    public function AfficherProduitCliques() {
        if (isset($_GET['id'])) {
            $idProduit = $_GET['id'];
            $produit = GestionProduit::getProduitById($idProduit);
            if ($produit) {
                VariablesGlobales::$lesProduits = $produit;
                require Chemins::VUES . 'v_produitsCliqués.php';
            } else {
                echo "Produit non trouvé.";
            }
        } else {
            echo "ID du produit non spécifié.";
        }
    }

    public function AjouterProduitPanier() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Récupération des données du produit à ajouter au panier
            $idProduit = $_POST['produit_id'];  
            $quantite = (int)$_POST['quantite'];  
    
            // Vérification si le panier existe déjà dans la session
            if (!isset($_SESSION['panier'])) {
                // Si le panier n'existe pas, on l'initialise
                Panier::initialiser();
            }
    
            // Ajout du produit au panier
            Panier::ajouterProduit($idProduit, $quantite);
        
            // Redirection vers la page du panier
            header('Location: index.php?controleur=Produits&action=afficherPanier');
            exit();
        }
    }
    
    public function afficherPanier() {
        Panier::initialiser();
        $produitsPanier = Panier::getProduits();
        
        // Vérification si le panier est vide
        if (Panier::isVide()) {
            $message = "Votre panier est vide.";
            return; // Si vide, on n'affiche rien
        }

        // Calcul du prix total
        $prixTotal = 0;

        // Inclusion de la vue du panier
        include Chemins::VUES . 'v_panier.inc.php';
    }

    public static function rechercherProduits() {
        // Vérifie si le paramètre 'recherche' existe
        if (isset($_GET['recherche'])) {
            $recherche = htmlspecialchars($_GET['recherche']);

            // Appel au modèle pour obtenir les produits correspondants
            $resultats = GestionProduit::rechercherProduits($recherche);

            // Inclure la vue qui affiche les résultats
            require Chemins::VUES . 'v_produitsRecherche.inc.php';
        } else {
            // En cas de paramètre manquant
            echo "<p>Erreur : Aucun paramètre de recherche reçu.</p>";
        }
    }


}
?>


