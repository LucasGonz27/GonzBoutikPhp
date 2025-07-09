<?php
//require_once '../../configs/mysql_config.class.php';
require_once 'ModelePdo.class.php';
require_once 'gestionBoutique.class.php';

class GestionProduit extends ModelePDO
{
    // -----------------------------------------------------------------------------------------------------
    // Suppression d'un produit
    // -----------------------------------------------------------------------------------------------------
    // Cette méthode supprime un produit en fonction de son ID
    public static function supprimerProduit($idProduit)
    {
        return GestionBoutique::supprimerTupleByChamp("produit", "id", $idProduit);
    }

    // -----------------------------------------------------------------------------------------------------
    // Récupération de produits
    // -----------------------------------------------------------------------------------------------------
    // Cette méthode retourne tous les produits de la base de données
    public static function getLesProduits()
    {
        return GestionBoutique::getLesTuplesByTable("produit");
    }

    // -----------------------------------------------------------------------------------------------------
    // Récupération d'un produit par son ID
    // -----------------------------------------------------------------------------------------------------
    // Cette méthode retourne un produit spécifique grâce à son ID
    public static function getProduitById($idProduit)
    {
        return GestionBoutique::getLeTupleTableById('produit', $idProduit);
    }

    // -----------------------------------------------------------------------------------------------------
    // Récupération des produits par marque
    // -----------------------------------------------------------------------------------------------------
    // Cette méthode retourne les produits correspondant à une marque donnée
    public static function getProduitsParMarque($nomMarque)
    {
        self::seConnecter();
        GestionBoutique::$requete = ("SELECT * FROM produit WHERE idMarque = (SELECT id FROM marque WHERE nom = :nomMarque)");
        GestionBoutique::$pdoStResults = GestionBoutique::$pdoCnxBase->prepare(GestionBoutique::$requete);
        GestionBoutique::$pdoStResults->bindValue(':nomMarque', $nomMarque);
        GestionBoutique::$pdoStResults->execute();
        $resultat = GestionBoutique::$pdoStResults->fetchAll(PDO::FETCH_ASSOC);
        GestionBoutique::$pdoStResults->closeCursor();
        return $resultat;
    }

    // -----------------------------------------------------------------------------------------------------
    // Récupération des produits par plage de prix
    // -----------------------------------------------------------------------------------------------------
    // Cette méthode retourne les produits dont le prix est compris entre deux valeurs
    public static function getProduitsParPrix($prixMin, $prixMax)
    {
        self::seConnecter();
        GestionBoutique::$requete = "SELECT * FROM produit WHERE prix BETWEEN :prixMin AND :prixMax";
        GestionBoutique::$pdoStResults = GestionBoutique::$pdoCnxBase->prepare(GestionBoutique::$requete);
        GestionBoutique::$pdoStResults->bindValue(':prixMin', $prixMin, PDO::PARAM_INT);
        GestionBoutique::$pdoStResults->bindValue(':prixMax', $prixMax, PDO::PARAM_INT);
        GestionBoutique::$pdoStResults->execute();
        $resultat = GestionBoutique::$pdoStResults->fetchAll(PDO::FETCH_ASSOC);
        GestionBoutique::$pdoStResults->closeCursor();
        return $resultat;
    }

    // -----------------------------------------------------------------------------------------------------
    // Récupération des produits par stockage
    // -----------------------------------------------------------------------------------------------------
    // Cette méthode retourne un produit en fonction de son type de stockage
    public static function getProduitByStockage($stockage)
    {
        return GestionBoutique::getLeTupleTableByChamp('produit', 'stockage', $stockage);
    }

    // -----------------------------------------------------------------------------------------------------
    // Récupération des produits par taille
    // -----------------------------------------------------------------------------------------------------
    // Cette méthode retourne un produit en fonction de sa taille
    public static function getProduitByTaille($taille)
    {
        return GestionBoutique::getLeTupleTableByChamp('produit', 'taille', $taille);
    }

    // -----------------------------------------------------------------------------------------------------
    // Récupération des produits par couleur
    // -----------------------------------------------------------------------------------------------------
    // Cette méthode retourne un produit en fonction de sa couleur
    public static function getProduitByCouleur($couleur)
    {
        return GestionBoutique::getLeTupleTableByChamp('produit', 'couleur', $couleur);
    }

    // -----------------------------------------------------------------------------------------------------
    // Récupération des produits par catégorie
    // -----------------------------------------------------------------------------------------------------
    // Cette méthode retourne les produits d'une catégorie donnée
    public static function getLesProduitsByCategorie($libelleCategorie)
    {
        GestionBoutique::seConnecter();
        GestionBoutique::$requete = "SELECT * FROM produit WHERE idCategorie = (SELECT idCategorie FROM categorie WHERE libelle = :libCateg)";
        GestionBoutique::$pdoStResults = GestionBoutique::$pdoCnxBase->prepare(GestionBoutique::$requete);
        GestionBoutique::$pdoStResults->bindValue(':libCateg', $libelleCategorie);
        GestionBoutique::$pdoStResults->execute();
        $resultat = GestionBoutique::$pdoStResults->fetchAll(PDO::FETCH_ASSOC);
        GestionBoutique::$pdoStResults->closeCursor();
        return $resultat;
    }

    // -----------------------------------------------------------------------------------------------------
    // Ajouter un produit
    // -----------------------------------------------------------------------------------------------------
    // Cette méthode ajoute un produit dans la base de données
    public static function ajouterProduit($nom, $description, $prix, $image, $couleur, $stockage, $stock, $libelleCateg, $nomFournisseur, $nomMarque)
    {
        GestionBoutique::seConnecter();
        GestionBoutique::$requete = "INSERT INTO produit (nom, description, prix, image, couleur, stockage, stock, idCategorie, idFournisseur, idMarque) 
        VALUES (:nom, :description, :prix, :image, :couleur, :stockage, :stock, 
            (SELECT id FROM categorie WHERE libelle = :libelleCateg), 
            (SELECT id FROM fournisseur WHERE nom = :nomFournisseur), 
            (SELECT id FROM marque WHERE nom = :nomMarque))";
        GestionBoutique::$pdoStResults = GestionBoutique::$pdoCnxBase->prepare(GestionBoutique::$requete);
        GestionBoutique::$pdoStResults->bindValue(':nom', $nom);
        GestionBoutique::$pdoStResults->bindValue(':description', $description);
        GestionBoutique::$pdoStResults->bindValue(':prix', $prix);
        GestionBoutique::$pdoStResults->bindValue(':image', $image);
        GestionBoutique::$pdoStResults->bindValue(':couleur', $couleur);
        GestionBoutique::$pdoStResults->bindValue(':stockage', $stockage);
        GestionBoutique::$pdoStResults->bindValue(':stock', $stock);
        GestionBoutique::$pdoStResults->bindValue(':libelleCateg', $libelleCateg);
        GestionBoutique::$pdoStResults->bindValue(':nomFournisseur', $nomFournisseur);
        GestionBoutique::$pdoStResults->bindValue(':nomMarque', $nomMarque);
        GestionBoutique::$pdoStResults->execute();
    }

    // -----------------------------------------------------------------------------------------------------
    // Modifier un produit
    // -----------------------------------------------------------------------------------------------------
    // Cette méthode permet de modifier les informations d'un produit
    public static function modifierProduit($idProduit, $nom, $description, $prix, $image, $libelleCateg, $nomFournisseur, $nomMarque)
    {
        GestionBoutique::seConnecter();
        GestionBoutique::$requete = "UPDATE produit SET nom = :nom, description = :description, prix = :prix, image = :image, idCategorie = (SELECT id FROM categorie WHERE libelle = :libelleCateg), idFournisseur = (SELECT id FROM fournisseur WHERE nom = :nomFournisseur), idMarque = (SELECT id FROM marque WHERE nom = :nomMarque) WHERE id = :id";
        GestionBoutique::$pdoStResults = GestionBoutique::$pdoCnxBase->prepare(GestionBoutique::$requete);
        GestionBoutique::$pdoStResults->bindValue(':id', $idProduit);
        GestionBoutique::$pdoStResults->bindValue(':nom', $nom);
        GestionBoutique::$pdoStResults->bindValue(':description', $description);
        GestionBoutique::$pdoStResults->bindValue(':prix', $prix);
        GestionBoutique::$pdoStResults->bindValue(':image', $image);
        GestionBoutique::$pdoStResults->bindValue(':libelleCateg', $libelleCateg);
        GestionBoutique::$pdoStResults->bindValue(':nomFournisseur', $nomFournisseur);
        GestionBoutique::$pdoStResults->bindValue(':nomMarque', $nomMarque);
        GestionBoutique::$pdoStResults->execute();
    }

    // -----------------------------------------------------------------------------------------------------
    // Recherche de produits
    // -----------------------------------------------------------------------------------------------------
    // Cette méthode permet de rechercher des produits par leur nom ou description
    public static function rechercherProduits($recherche)
    {
        // Connexion à la base de données
        GestionBoutique::seConnecter();
        // Requête SQL pour rechercher dans le nom ou la description
        GestionBoutique::$requete = "SELECT * FROM produit WHERE nom LIKE :recherche OR description LIKE :recherche";
        GestionBoutique::$pdoStResults = GestionBoutique::$pdoCnxBase->prepare(GestionBoutique::$requete);
        GestionBoutique::$pdoStResults->bindValue(':recherche', '%' . $recherche . '%', PDO::PARAM_STR);
        GestionBoutique::$pdoStResults->execute();
        $resultats = GestionBoutique::$pdoStResults->fetchAll(PDO::FETCH_ASSOC);
        GestionBoutique::$pdoStResults->closeCursor();
        return $resultats;
    }

  
}


//---------------------------------------test des méthodes ---------------------------------------------------------------------------------------------
// Exemples d'appels de méthodes pour tester

//-----PRODUIT PAR CATEGORIE--------
//var_dump(GestionProduit::getLesProduitsByCategorie("smartphone"));
//$produit  = GestionProduit::getLesProduits();
//var_dump($produit)

//-----PRODUIT PAR STOCKAGE--------
//var_dump(GestionProduit::getProduitByCouleur("Noir"));

//-----PRODUIT PAR ID--------
//var_dump(GestionProduit::getProduitById(18));

//-----NOMBRE DE PRODUIT--------
//var_dump(GestionProduit::getNbProduits());

//-----AJOUT DE PRODUIT--------
//GestionProduit::ajouterProduit('S35', 'Smartphone Samsung S35 Fe', 1650.69, 'S35.jpg', 'Bleu', 128, 50, 'smartphone', 'Fournisseur Samsung', 'Samsung');

//------SUPPRIME UN PRODUIT---------
//GestionProduit::supprimerProduit(18);

//------MODIFIE UN PRODUIT-----------
//GestionProduit::modifierProduit(97, 'S35', 'Sma', 1600.69, 'S35.jpg', 'smartphone','Fournisseur Samsung','Iphone');

//------PRODUIT PAR MARQUE------------
//var_dump(GestionProduit::getProduitsParMarque('Samsung'));

//-------PRODUIT PAR COULEUR----------------
//var_dump(GestionProduit::getProduitByCouleur('Noir'));

//-------PRODUIT PAR PRIX DE 100 A 200------
//var_dump(GestionProduit::getProduitByPrix100_200());

//------PRODUIT PAR PRIX DE 200 A 300------ 
//var_dump(GestionProduit::getProduitByPrix200_300());

//------PRODUIT PAR PRIX DE 300 A 400------ 
//var_dump(GestionProduit::getProduitByPrix300_400());

//------PRODUIT PAR PRIX DE 400 A 500------ 
//var_dump(GestionProduit::getProduitByPrix400_500());

//------PRODUIT PAR PRIX DE 500 A PLUS------ 
//var_dump(GestionProduit::getProduitByPrix500Plus());
