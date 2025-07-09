    <?php
    require_once 'gestionBoutique.class.php';

    class GestionMarque extends ModelePDO {

         //retourne les marques ->
         public static function getLesMarques() {
            return GestionBoutique::getLesTuplesByTable("marque");
        }

        public static function supprimerMarque($id) {
            return GestionBoutique::supprimerTupleByChamp("marque", "id", $id);
        }
    

        //ajoute une marque
        public static function ajouterMarque($nomMarque){
            GestionBoutique::seConnecter();
            GestionBoutique::$requete = "INSERT INTO marque(nom) VALUES(:nom)";
            GestionBoutique::$pdoStResults = GestionBoutique::$pdoCnxBase->prepare(GestionBoutique::$requete);
            GestionBoutique::$pdoStResults->bindValue(':nom', $nomMarque);
            GestionBoutique::$pdoStResults->execute();
        }
        //supprime une marque -> 
      
        
        
        //modifie une marque
        public static function modifierMarque($idMarque, $nouveauNom) {
            GestionBoutique::seConnecter();
            GestionBoutique::$requete = "UPDATE marque SET nom = :nom WHERE idMarque = :idMarque";
            GestionBoutique::$pdoStResults = GestionBoutique::$pdoCnxBase->prepare(GestionBoutique::$requete);
            GestionBoutique::$pdoStResults->bindValue(':nom', $nouveauNom);
            GestionBoutique::$pdoStResults->bindValue(':idMarque', $idMarque);
            GestionBoutique::$pdoStResults->execute();
        }
    }
                
                    
       


    //---------------------------------------test des methodes ---------------------------------------------------------------------------------------------
    //GestionBoutique::seConnecter();

    //-----AJOUT DE MARQUE--------
    //var_dump(GestionMarque::ajouterMarque('pd'));

    //-----VISUALISATION DES MARQUES--------
    //var_dump(GestionMarque::getLesMarques());

    //-----SUPRESSION DE MARQUE--------
    //var_dump(GestionMarque::supprimerMarque('pd'));

    //-----MODIFICATION DE CLIENT--------
    //var_dump(GestionMarque::modifierMarque(1, 'Adidas'));
    ?>




