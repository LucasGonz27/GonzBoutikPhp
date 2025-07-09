<?php

//inclusion de la classe MysqlConfig
//à partir de l'emplacement actuel (dossier "modeles")
//require_once '../../configs/mysql_config.class.php';
require_once 'ModelePdo.class.php';



class GestionBoutique extends ModelePDO {

 public static function isAdminOk($login, $mdp) {
    self::seConnecter();
    self::$requete = "SELECT * FROM admin WHERE login=:login AND mdp=:mdp";
    self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
    self::$pdoStResults->bindValue(':login', $login);
    self::$pdoStResults->bindValue(':mdp', ($mdp)); 
    self::$pdoStResults->execute();
    self::$resultat = self::$pdoStResults->fetch(PDO::FETCH_OBJ);
    self::$pdoStResults->closeCursor();
    return self::$resultat != null;
}

 public static function isClientOK($email, $mdp) {
    self::seConnecter();
    self::$requete = "SELECT * FROM client WHERE email=:email AND mdp=:mdp";
    self::$pdoStResults = self::$pdoCnxBase->prepare(self::$requete);
    self::$pdoStResults->bindValue(':email', $email);
    self::$pdoStResults->bindValue(':mdp', ($mdp)); 
    self::$pdoStResults->execute();
    self::$resultat = self::$pdoStResults->fetch(PDO::FETCH_OBJ);
    self::$pdoStResults->closeCursor();
    return self::$resultat != null;
}

}
?>

<?php

//tests des services (méthodes) de la classe GestionBoutique
//----------------------------------------------------------

?>