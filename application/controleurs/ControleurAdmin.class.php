<?php

class ControleurAdmin
{

    public function __construct()
    {
        // si on séparait les modèles, le constructeur donnerait son chemin
        // require_once Chemins::MODELES.'gestion_categories.class.php';
    }


    public function afficherIndex()
    {
        if (isset($_SESSION['login_admin']))
            require Chemins::VUES_ADMIN . 'v_indexAdmin.inc.php';
        else
            require Chemins::VUES_ADMIN . 'v_connexion.inc.php';
    }


    public function verifierConnexion()
    {

        if (GestionBoutique::isAdminOK($_POST['login'], $_POST['mdp'])) {
            $_SESSION['login_admin'] = $_POST['login'];
            if (isset($_POST['connexion_auto']))
                setcookie('login_admin', $_POST['login'], time() + 7 * 24 * 3600, null, null, false, true);
            //Le cookie sera valable dans ce cas 1 semaine (7 jours)
            require Chemins::VUES_ADMIN . 'v_indexAdmin.inc.php';
        } else
            require Chemins::VUES_ADMIN . 'v_erreur404.inc.php';
    }

    public function seDeconnecter()
    {
        $_SESSION = array();
        session_destroy();
        header("Location:index.php");
        setcookie('login_admin', '');
    }

    public function afficherClient()
    {
        require_once Chemins::VUES_ADMIN . 'v_GestionClient.php';
    }

    public function afficherProduit()
    {
        require_once Chemins::VUES_ADMIN . 'v_GestionProduit.php';
    }

    public function afficherMarque()
    {
        require_once Chemins::VUES_ADMIN . 'v_GestionMarque.php';
    }

    public function afficherCategorie()
    {
        require_once Chemins::VUES_ADMIN . 'v_GestionCategorie.php';
    }

    public function afficherFournisseur()
    {
        require_once Chemins::VUES_ADMIN . 'v_GestionFournisseur.php';
    }

    public function afficherCommande()
    {
        require_once Chemins::VUES_ADMIN . 'v_GestionCommande.php';
    }
}
