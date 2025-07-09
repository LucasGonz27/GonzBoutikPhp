<?php

class ControleurCategories {
    public function __construct() {
        // si on séparait les modèles, le constructeur donnerait son chemin
        // require_once Chemins::MODELES.'gestion_categories.class.php';
    }

    public function afficher() {
        VariablesGlobales::$lesMarques = GestionMarque::getLesMarques();
    }
    
}

?>