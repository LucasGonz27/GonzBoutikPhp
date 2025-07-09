<?php
require_once 'gestionBoutique.class.php';

class GestionClient extends ModelePDO {

    // ----- Récupération des clients -----

    /**
     * Retourne tous les clients.
     * 
     * @return array Liste des clients
     */
    public static function getLesClients() {
        return GestionBoutique::getLesTuplesByTable("client");
    }

    public static function getClientParEmail($email) {
        // On utilise la méthode getLeTupleTableByChamp pour récupérer le client par son email
        $resultat = GestionBoutique::getLeTupleTableByChamp('client', 'email', $email);
        
        // Vérifier si un client a été trouvé
        if (!empty($resultat)) {
            // Retourner l'ID du client (en supposant que le premier élément contient les données du client)
            return $resultat[0]['id'];
        } else {
            // Si aucun client n'est trouvé, retourner null ou une valeur appropriée
            return null;
        }
    }
    

    /**
     * Retourne le nombre de clients.
     * 
     */
    public static function getNbClients() {
        self::seConnecter();
        self::$requete = "CALL _GetAllClients()";
        self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
        self::$pdoStResults->execute();
        self::$resultat = self::$pdoStResults->fetchAll(PDO::FETCH_ASSOC);
        self::$pdoStResults->closeCursor();
        return count(self::$resultat); 
    }
    
    /**
     * Récupère un client par son ID.
     * 
     * @param int $idClient ID du client
     * @return array Données du client
     * @throws Exception Si l'ID client est invalide
     */
    public static function getLesClientsById($idClient) {
        if (!$idClient) {
            throw new Exception("Client ID is invalid");
        }
        return GestionBoutique::getLeTupleTableById("client", $idClient);
    }

    // ----- Suppression des clients -----

    /**
     * Supprime un client par son ID.
     * 
     * @param int $idClient ID du client à supprimer
     * @return bool Résultat de la suppression
     */
    public static function supprimerClient($idClient) {
        return GestionBoutique::supprimerTupleByChamp("client", "id", $idClient);
    }

    // ----- Ajout d'un client -----

    /**
     * Ajoute un client dans la base de données.
     * 
     * @param string $nom Nom du client
     * @param string $prenom Prénom du client
     * @param string $rue Adresse du client
     * @param string $codePostal Code postal du client
     * @param string $ville Ville du client
     * @param string $tel Téléphone du client
     * @param string $email Email du client
     * @param string $mdp Mot de passe du client
     */
    public static function ajouterClient($nom, $prenom, $rue, $codePostal, $ville, $tel, $email, $mdp) {
        GestionBoutique::seConnecter();
        GestionBoutique::$requete = "INSERT INTO client (nom, prenom, rue, codePostal, ville, tel, email, mdp) 
                                     VALUES (:nom, :prenom, :rue, :codePostal, :ville, :tel, :email, :mdp)";
        GestionBoutique::$pdoStResults = GestionBoutique::$pdoCnxBase->prepare(GestionBoutique::$requete);
        GestionBoutique::$pdoStResults->bindValue(':nom', $nom);
        GestionBoutique::$pdoStResults->bindValue(':prenom', $prenom);
        GestionBoutique::$pdoStResults->bindValue(':rue', $rue);
        GestionBoutique::$pdoStResults->bindValue(':codePostal', $codePostal);
        GestionBoutique::$pdoStResults->bindValue(':ville', $ville);
        GestionBoutique::$pdoStResults->bindValue(':tel', $tel);
        GestionBoutique::$pdoStResults->bindValue(':email', $email);
        GestionBoutique::$pdoStResults->bindValue(':mdp', $mdp);
        GestionBoutique::$pdoStResults->execute();
    }

    // ----- Modification d'un client -----

    /**
     * Modifie les informations d'un client.
     * 
     * @param int $idClient ID du client à modifier
     * @param string $nom Nom du client
     * @param string $prenom Prénom du client
     * @param string $adresse Adresse du client
     * @param string $ville Ville du client
     * @param string $codePostal Code postal du client
     * @param string $tel Téléphone du client
     * @param string $email Email du client
     * @param string $mdp Mot de passe du client
     */
    public static function modifierClient($idClient, $nom, $prenom, $adresse, $ville, $codePostal, $tel, $email, $mdp) {
        GestionBoutique::seConnecter();
        GestionBoutique::$requete = "UPDATE client SET nom = :nom, prenom = :prenom, rue = :rue, ville = :ville, codePostal = :codePostal, tel = :tel, email = :email, mdp = :mdp WHERE id = :id";
        GestionBoutique::$pdoStResults = GestionBoutique::$pdoCnxBase->prepare(GestionBoutique::$requete);
        GestionBoutique::$pdoStResults->bindValue(':id', $idClient);
        GestionBoutique::$pdoStResults->bindValue(':nom', $nom);
        GestionBoutique::$pdoStResults->bindValue(':prenom', $prenom);
        GestionBoutique::$pdoStResults->bindValue(':rue', $adresse); // 'adresse' devient 'rue'
        GestionBoutique::$pdoStResults->bindValue(':ville', $ville);
        GestionBoutique::$pdoStResults->bindValue(':codePostal', $codePostal);
        GestionBoutique::$pdoStResults->bindValue(':tel', $tel);
        GestionBoutique::$pdoStResults->bindValue(':email', $email);
        GestionBoutique::$pdoStResults->bindValue(':mdp', $mdp);
        GestionBoutique::$pdoStResults->execute();
    }

    // ----- Récupération des informations d'un client par email -----

    /**
     * Récupère les informations d'un client par son email.
     * 
     * @param string $emailClient Email du client
     * @return array Données du client
     */
    public static function getInfoClient($emailClient) {
        GestionBoutique::seConnecter();
        GestionBoutique::$requete = "SELECT * FROM client WHERE email = :email";
        GestionBoutique::$pdoStResults = GestionBoutique::$pdoCnxBase->prepare(GestionBoutique::$requete);
        GestionBoutique::$pdoStResults->bindValue(':email', $emailClient);
        GestionBoutique::$pdoStResults->execute();
        $resultat = GestionBoutique::$pdoStResults->fetch(PDO::FETCH_ASSOC);
        GestionBoutique::$pdoStResults->closeCursor();
        return $resultat;
    }
}





//---------------------------------------test des methodes ---------------------------------------------------------------------------------------------

//-----AJOUT DE CLIENT--------
//var_dump(GestionClient::ajouterClient('jean','kevin','123','2020-05-21',649876302,'JeanKevin@gmail.com','rue des fdp', 'Narbonne',11500));


//-----VISUALISATION DES CLIENT--------
//var_dump(GestionClient::getLesClients());

//-----SUPRESSION DE CLIENT--------
//var_dump(GestionClient::supprimerClient(3));

//-----MODIFICATION DE CLIENT--------
//var_dump(GestionClient::modifierClient(1, 'Tobi', 'kevin', '123'', 649876302, 'JeanKevin@gmail.com', 'rue des fdp', 'Narbonne', 11500));

//var_dump(GestionClient::getClientParEmail('lucas.gonz2702@gmail.com'));
?>
