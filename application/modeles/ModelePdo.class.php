<?php

class ModelePDO

{

    //Attributs utiles pour la connexion
    protected static $serveur = MySqlConfig::SERVEUR;
    protected static $base = MySqlConfig::BASE;
    protected static $utilisateur = MySqlConfig::UTILISATEUR;
    protected static $passe = MySqlConfig::MOT_DE_PASSE;
    protected static $pdoCnxBase = null;
    protected static $pdoStResults = null;
    protected static $requete = "";
    protected static $resultat = null;


    protected static function seConnecter()
    {
        if (!isset(self::$pdoCnxBase)) { //S'il n'y a pas encore eu de connexion
            try {
                self::$pdoCnxBase = new PDO(
                    'mysql:host=' . self::$serveur . ';dbname=' . self::$base,
                    self::$utilisateur,
                    self::$passe
                );
                self::$pdoCnxBase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdoCnxBase->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                self::$pdoCnxBase->query("SET CHARACTER SET utf8"); //méthode de la classe PDO
            } catch (Exception $e) {
                echo 'Erreur : ' . $e->getMessage() . '<br />'; // méthode de la classe Exception
                echo 'Code : ' . $e->getCode(); // méthode de la classe Exception
            }
        }
    }

    protected static function seDeconnecter()
    {
        self::$pdoCnxBase = null;
        // Si on n'appelle pas la méthode, la déconnexion a lieu en fin de script
    }



    protected static function getLesTuplesByTable($table)
    {
        self::seConnecter();
        self::$requete = "SELECT * FROM $table";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->execute();
        self::$resultat = self::$pdoStResults->fetchAll();
        self::$pdoStResults->closeCursor();
        return self::$resultat;
    }

    protected static function getLeTupleTableById($table, $id)
    {
        self::seConnecter();
        self::$requete = "SELECT * FROM $table WHERE id = :id";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->bindValue(':id', $id);
        self::$pdoStResults->execute();
        self::$resultat = self::$pdoStResults->fetch();
        self::$pdoStResults->closeCursor();
        return self::$resultat;
    }

    protected static function getNbTuples($table)
    {
        self::seConnecter();
        self::$requete = "SELECT COUNT(*) AS nbTuples FROM $table";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->execute();
        self::$resultat = self::$pdoStResults->fetch(PDO::FETCH_OBJ);
        self::$pdoStResults->closeCursor();
        return self::$resultat->nbTuples;
    }

    protected static function getLeTupleTableByChamp($table, $colonne, $valeur)
    {
        self::seConnecter();
        self::$requete = "SELECT * FROM $table WHERE $colonne = :valeur";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->bindValue(':valeur', $valeur);
        self::$pdoStResults->execute();
        self::$resultat = GestionBoutique::$pdoStResults->fetchAll(PDO::FETCH_ASSOC);
        self::$pdoStResults->closeCursor();
        return self::$resultat;
    }

    protected static function getLesValeursDistinctesParColonne($table, $colonne)
    {
        self::seConnecter();
        self::$requete = "SELECT DISTINCT $colonne FROM $table";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->execute();
        self::$resultat = self::$pdoStResults->fetchAll(PDO::FETCH_OBJ);
        self::$pdoStResults->closeCursor();
        return self::$resultat;
    }





    protected static function supprimerTupleByChamp($table, $colonne, $valeur)
    {
        self::seConnecter();
        self::$requete = "DELETE FROM $table WHERE $colonne = :valeur";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->bindValue(':valeur', $valeur);
        self::$pdoStResults->execute();
        self::$pdoStResults->closeCursor();
    }

    protected static function select($champs, $tables, $conditions = null)
    {
        self::seConnecter();
        self::$requete = "SELECT " . $champs . " FROM " . $tables;
        if ($conditions != null)
            self::$requete .= " WHERE " . $conditions;
    }
}
