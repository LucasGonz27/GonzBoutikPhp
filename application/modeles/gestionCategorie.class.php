<?php
    require_once 'gestionBoutique.class.php';

    class GestionCategorie extends ModelePDO {
        public static function getLesCategories() {
            return GestionBoutique::getLesTuplesByTable("categorie");
        }

           //supprime une catégorie ->
           public static function supprimerCategorie($libelle){
            return GestionBoutique::supprimerTupleByChamp("categorie", "libelle", $libelle);
        }
        
    
        
        //ajoute une catégorie ->
         public static function ajouterCategorie($libelleCateg) {
            GestionBoutique::seConnecter();
            GestionBoutique::$requete = "insert into Categorie(libelle) values(:libelle)";
            GestionBoutique::$pdoStResults = GestionBoutique::$pdoCnxBase->prepare(GestionBoutique::$requete);
            GestionBoutique::$pdoStResults->bindValue('libelle', $libelleCateg);
            GestionBoutique::$pdoStResults->execute();
         }
        
     
          //modifier une catégorie ->
        public static function modifierCategorie($idCategorie, $libelleCateg) {
            GestionBoutique::seConnecter();
            GestionBoutique::$requete = "UPDATE categorie SET libelle = :libelle WHERE idCategorie = :idCategorie";
            GestionBoutique::$pdoStResults = GestionBoutique::$pdoCnxBase->prepare(GestionBoutique::$requete);
            GestionBoutique::$pdoStResults->bindValue(':libelle', $libelleCateg);
            GestionBoutique::$pdoStResults->bindValue(':idCategorie', $idCategorie);
            GestionBoutique::$pdoStResults->execute();
        }
    }
    
    // ----- TEST DES MÉTHODES DE GestionCategorie -----

// ----- VISUALISATION DES CATÉGORIES -----
// var_dump(GestionCategorie::getLesCategories());

// ----- AJOUT D'UNE CATÉGORIE -----
// GestionCategorie::ajouterCategorie('Nouvelle catégorie');

// ----- SUPPRESSION D'UNE CATÉGORIE -----
//GestionCategorie::supprimerCategorie('Tablette');

// ----- MODIFICATION D'UNE CATÉGORIE -----
// GestionCategorie::modifierCategorie(1, 'Catégorie modifiée');
?>
