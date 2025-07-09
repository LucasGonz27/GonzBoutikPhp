    <?php

    require_once Chemins::MODELES . 'Panier.class.php';
    require_once Chemins::MODELES . 'gestionCommande.class.php';
    class ControleurPanier
    {

        public function retirerProduit()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $idProduit = $_POST['produit_id'];
                Panier::initialiser();
                Panier::retirerProduit($idProduit);
                header('Location: index.php?controleur=Produits&action=afficherPanier');
                exit();
            } else {

                echo 'Méthode invalide.';
            }
        }
        public function viderPanier()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Vider le panier
                $_SESSION['produits'] = [];

                // Rediriger vers la page d'accueil
                header('Location: index.php?cas=afficherAccueil');
                exit();
            }
        }

        public function validerCommande()
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Vérifier si l'utilisateur est connecté
                if (!isset($_SESSION['login_client'])) {
                    // Si non connecté, rediriger vers la page de connexion avec un message
                    $_SESSION['error'] = "Vous devez être connecté pour passer une commande.";
                    header('Location: index.php?controleur=Connexion&action=afficherCompteClient');
                    exit();
                }

                // Si connecté, continuer avec la validation de la commande
                $email = $_SESSION['login_client'];
                $client = GestionClient::getClientParEmail($email);
            
                // Récupérer d'autres données nécessaires
                $moyenPaiement = 'CB';
                $dateDuJour = date('Y-m-d');
            
                // Initialiser le total de la commande
                $prixTotal = 0;
            
                // Création de la commande
                $idCommande = GestionCommande::creerCommande($dateDuJour, $client, 'En attente', $moyenPaiement, $prixTotal);
            
                // Récupérer les produits du panier
                $produitsPanier = Panier::getProduits();
            
                // Ajouter les lignes de commande et calculer le total
                foreach ($produitsPanier as $idProduit => $quantite) {
                    $produit = GestionProduit::getProduitById($idProduit);
                    $prixUni = $produit->prix;
            
                    $sousTotal = $prixUni * $quantite;
                    $prixTotal += $sousTotal;
            
                    GestionCommande::ajouterLigneDeCommande($idCommande, $idProduit, $quantite, $prixUni, $sousTotal);
                }
            
                // Mise à jour du total de la commande
                GestionCommande::mettreAJourTotalCommande($idCommande, $prixTotal);
            
                // Rediriger vers la page récapitulative
                $_SESSION['idCommande'] = $idCommande;
                header('Location: index.php?controleur=Panier&action=recapitulatifCommande&idCommande=' . $idCommande);
                exit();
            } else {
                echo "Méthode non autorisée.";
            }
        }
        


        public function recapitulatifCommande()
        {
            // Vérifier que l'ID de la commande existe dans la session ou dans les paramètres
            if (isset($_SESSION['idCommande']) || isset($_GET['idCommande'])) {
                $idCommande = $_SESSION['idCommande'] ?? $_GET['idCommande'];

                // Récupérer les détails de la commande
                $commande = GestionCommande::getCommandeById($idCommande); // Méthode pour récupérer la commande par ID
                $lignesCommande = GestionCommande::getLignesDeCommande($idCommande); // Récupérer les lignes de la commande

                // Passer les données à la vue
                require Chemins::VUES . 'recapitulatifCommande.php';
            } else {
                // Si l'ID de la commande est manquant, rediriger ou afficher une erreur
                echo "Erreur : ID de commande manquant.";
            }
        }
    }
