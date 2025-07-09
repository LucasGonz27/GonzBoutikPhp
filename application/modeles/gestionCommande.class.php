<?php
require_once 'gestionBoutique.class.php';



class GestionCommande extends ModelePDO
{
    // Méthode pour créer une commande
    public static function creerCommande($date, $idClient, $statut, $moyenPaiement, $total)
    {
        // On se connecte à la base de données
        self::seConnecter();
    
        // Créer la commande dans la table commande
        self::$requete = "INSERT INTO commande (date, idClient, statut, moyenPaiement, total) 
                          VALUES (:date, :idClient, :statut, :moyenPaiement, :total)";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->bindValue(':date', $date);
        self::$pdoStResults->bindValue(':idClient', $idClient);
        self::$pdoStResults->bindValue(':statut', $statut);
        self::$pdoStResults->bindValue(':moyenPaiement', $moyenPaiement);
        self::$pdoStResults->bindValue(':total', $total);
        self::$pdoStResults->execute();
    
        // Récupérer l'ID de la commande insérée
        $idCommande = self::$pdoCnxBase->lastInsertId();
    
        // Vérification de l'ID récupéré
        var_dump($idCommande); // Pour vérifier l'ID récupéré
    
        // Fermer le curseur
        self::$pdoStResults->closeCursor();
    
        // Retourner l'ID de la commande
        return $idCommande;
    }
    

    public static function ajouterLigneDeCommande($idCommande, $idProduit, $quantite, $prixUni, $sousTotal)
    {
        self::seConnecter();

        // Insertion de la ligne de commande
        self::$requete = "INSERT INTO lignedecommande (idCommande, idProduit, quantite, prixUnitaire, sousTotal) 
                          VALUES (:idCommande, :idProduit, :quantite, :prixUnitaire, :sousTotal)";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->bindValue(':idCommande', $idCommande);
        self::$pdoStResults->bindValue(':idProduit', $idProduit);
        self::$pdoStResults->bindValue(':quantite', $quantite);
        self::$pdoStResults->bindValue(':prixUnitaire', $prixUni);
        self::$pdoStResults->bindValue(':sousTotal', $sousTotal);
        self::$pdoStResults->execute();
        self::$pdoStResults->closeCursor();
    }


    // Méthode pour mettre à jour le total de la commande
    public static function mettreAJourTotalCommande($idCommande, $prixTotal)
    {
        // Se connecter à la base de données
        self::seConnecter();

        // Requête pour mettre à jour le total de la commande
        $requete = "UPDATE commande SET total = :total WHERE id = :idCommande";

        // Préparation et exécution de la requête
        self::$pdoStResults = self::$pdoCnxBase->prepare($requete);
        self::$pdoStResults->bindValue(':total', $prixTotal);
        self::$pdoStResults->bindValue(':idCommande', $idCommande);
        self::$pdoStResults->execute();
        self::$pdoStResults->closeCursor();
    }





    // Méthode pour récupérer toutes les commandes d'un client
    public static function getCommandesByClient($idClient)
    {
        // On se connecte à la base de données
        self::seConnecter();

        // Récupérer toutes les commandes du client
        self::$requete = "SELECT * FROM commande WHERE idClient = :idClient";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->bindValue(':idClient', $idClient);
        self::$pdoStResults->execute();

        $commandes = self::$pdoStResults->fetchAll();
        self::$pdoStResults->closeCursor();

        return $commandes;
    }

    // Méthode pour récupérer les lignes de commande d'une commande
    public static function getLignesDeCommande($idCommande)
    {
        // On se connecte à la base de données
        self::seConnecter();

        // Récupérer toutes les lignes de la commande
        self::$requete = "SELECT * FROM lignedecommande WHERE idCommande = :idCommande";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->bindValue(':idCommande', $idCommande);
        self::$pdoStResults->execute();

        $lignesDeCommande = self::$pdoStResults->fetchAll();
        self::$pdoStResults->closeCursor();

        return $lignesDeCommande;
    }


    public static function getCommandeById($idCommande)
    {
        // Requête SQL pour récupérer les détails de la commande
        $requete = "SELECT * FROM commande WHERE id = :idCommande";
        $pdoSt = self::$pdoCnxBase->prepare($requete);
        $pdoSt->bindValue(':idCommande', $idCommande);
        $pdoSt->execute();

        // Retourne la commande si elle existe, sinon false
        return $pdoSt->fetch(PDO::FETCH_ASSOC);
    }
}
