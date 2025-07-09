<?php
//require_once '../../configs/mysql_config.class.php';
require_once 'gestionBoutique.class.php';


class GestionFournisseur extends ModelePDO
{


    //retourne les fournisseurs ->
    public static function getLesFournisseurs()
    {
        return GestionBoutique::getLesTuplesByTable("fournisseur");
    }

      //supprimer fournisseur ->
      public static function supprimerFournisseur($idFournisseur)
      {
        return GestionBoutique::supprimerTupleByChamp("fournisseur", "id", $idFournisseur);
      }



    public static function ajouterFournisseur($nom, $rue, $codePostal, $ville, $tel, $email)
    {
        GestionBoutique::seConnecter();
        GestionBoutique::$requete = "INSERT INTO fournisseur (nom, rue, codePostal, ville, tel, email) VALUES (:nom, :rue, :codePostal, :ville, :tel, :email)";
        GestionBoutique::$pdoStResults = GestionBoutique::$pdoCnxBase->prepare(GestionBoutique::$requete);
        GestionBoutique::$pdoStResults->bindValue(':nom', $nom);
        GestionBoutique::$pdoStResults->bindValue(':rue', $rue);
        GestionBoutique::$pdoStResults->bindValue(':codePostal', $codePostal);
        GestionBoutique::$pdoStResults->bindValue(':ville', $ville);
        GestionBoutique::$pdoStResults->bindValue(':tel', $tel);
        GestionBoutique::$pdoStResults->bindValue(':email', $email);
        GestionBoutique::$pdoStResults->execute();
    }


    //modifier un fournisseur ->
    public static function modifierFournisseur($idFournisseur, $nom, $rue, $codePostal, $ville, $tel, $email)
    {
        GestionBoutique::seConnecter();
        GestionBoutique::$requete = "UPDATE fournisseur SET nom = :nom, rue = :rue, codePostal = :codePostal, ville = :ville, tel = :tel, email = :email WHERE id = :id";
        GestionBoutique::$pdoStResults = GestionBoutique::$pdoCnxBase->prepare(GestionBoutique::$requete);
        GestionBoutique::$pdoStResults->bindValue(':id', $idFournisseur);
        GestionBoutique::$pdoStResults->bindValue(':nom', $nom);
        GestionBoutique::$pdoStResults->bindValue(':rue', $rue);
        GestionBoutique::$pdoStResults->bindValue(':codePostal', $codePostal);
        GestionBoutique::$pdoStResults->bindValue(':ville', $ville);
        GestionBoutique::$pdoStResults->bindValue(':tel', $tel);
        GestionBoutique::$pdoStResults->bindValue(':email', $email);
        GestionBoutique::$pdoStResults->execute();
    }
}

//---------------------------------------test des methodes ---------------------------------------------------------------------------------------------

    
//-----AJOUT DE FOURNISSEUR--------
//var_dump(GestionFournisseur::ajouterFournisseur("ooooooooo", "oooooooooooo", "11200", "ooooo", "1115151", "thhty"));


//-----MODIFIER UN FOURNISSEUR--------
//var_dump(GestionProduit::getProduitByStockage("1To"));

//-----SUPPRIMER UN FOURNISSEUR--------
//var_dump(GestionProduit::getProduitById(18));
