<?php

class ControleurConnexion {


    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // Vous pouvez charger des modèles spécifiques ici si nécessaire
    }

    // Affiche le formulaire d'inscription
    public function afficherFormulaireInscription() {
        require Chemins::VUES_CLIENT . 'v_inscription.inc.php';
    }

// Affiche le formulaire de connexion ou compte
public function afficherCompteClient() {
    // Vérifie si un client est connecté, si oui, redirige vers la page du compte client
    if (isset($_SESSION['login_client'])) {
        // Récupère l'email du client à partir de la session
        $emailClient = $_SESSION['login_client'];

        // Récupère les informations du client
        $infosClient = GestionClient::getInfoClient($emailClient);

        if ($infosClient) {
            // Récupère les données du client
            $email = $infosClient['email'];
            $tel = $infosClient['tel'];
            $rue = $infosClient['rue'];
            $codePostal = $infosClient['codePostal'];
            $ville = $infosClient['ville'];
            $mdp = $infosClient['mdp'];
            $prenom = $infosClient['prenom'];

            // Inclut la vue avec les informations du client
            require Chemins::VUES_CLIENT . 'v_espace_client.inc.php';
        } else {
            echo "Erreur lors de la récupération des informations du client.";
        }
    } else {
        require Chemins::VUES_CLIENT . 'v_connexion.inc.php';
    }
}



    // Vérification de la connexion du client
    public function verifierConnexionClient() {
        // Vérifie si le client existe
        if (GestionBoutique::isClientOK($_POST['email'], $_POST['mdp'])) {
            // Sauvegarde la session et les cookies
            $_SESSION['login_client'] = $_POST['email'];
            if (isset($_POST['connexion_auto'])) {
                setcookie('login_client', $_POST['email'], time() + 7*24*3600, null, null, false, true);
            }
            // Redirection vers la page du compte client
            header("Location: index.php?controleur=Connexion&action=afficherCompteClient");
            exit;
        } else {
            // Ajoute un message d'erreur en cas d'identifiants invalides
            $messageErreur = "Aucun compte n'est lié à ces données.";
            header("Location: index.php?controleur=Connexion&action=afficherCompteClient&messageErreur=" . urlencode($messageErreur));
            exit;
        }
    }
    



    // Inscription du client
    public function inscrireClient() {
        // Récupérer les données du formulaire
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $mdp = $_POST['mdp'];
        $rue = $_POST['rue'];
        $codePostal = $_POST['codePostal'];
        $ville = $_POST['ville'];
        $tel = $_POST['tel'];
    
        try {
            // Appel de la méthode pour ajouter un client
            GestionClient::ajouterClient($nom, $prenom, $rue, $codePostal, $ville, $tel, $email, $mdp);
            // Rediriger vers la page de connexion avec un message de succès
            $_SESSION['message'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
            header("Location: index.php?controleur=Connexion&action=afficherCompteClient");
            exit();
        } catch (PDOException $e) {
            // Si une erreur liée à l'email existe déjà, on l'affiche
            if ($e->getCode() == '45000') {
                $_SESSION['error'] = "Un client avec cette adresse e-mail existe déjà.";
            } else {
                $_SESSION['error'] = "Une erreur est survenue, veuillez réessayer plus tard.";
            }
            // Rediriger vers le formulaire d'inscription
            header("Location: index.php?controleur=Connexion&action=afficherFormulaireInscription");
            exit();
        }
    }
    

    // Déconnexion du client
    public function seDeconnecter() {
        $_SESSION = array();
        session_destroy();
        setcookie('login_client', '', time() - 3600, null, null, false, true);
        header("Location: index.php");
        exit;
    }
}

?>
