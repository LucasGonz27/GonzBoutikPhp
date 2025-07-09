<?php
require_once Chemins::VUES_ADMIN . 'v_enteteAdmin.php'; // Entête de la page
require_once Chemins::VUES_ADMIN . 'v_menuGaucheAdmin.php'; // Menu latéral
?>
<br><br><br>
<!-- Conteneur central -->
<div class="container my-5 custom-container">



    <!-- Section des clients -->
    <section class="client-section">
        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
            <h2 class="text-center mb-4">Tableau des clients</h2>
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Adresse</th>
                        <th scope="col">Téléphone</th>
                        <th scope="col">Email</th>
                        <th scope="col">Mot de passe</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $Clients = GestionClient::getLesClients();
                    foreach ($Clients as $unClient) {
                        echo "<tr>";
                        echo "<td>$unClient->nom</td>";
                        echo "<td>$unClient->prenom</td>";
                        echo "<td>$unClient->rue $unClient->codePostal $unClient->ville</td>";
                        echo "<td>$unClient->tel</td>";
                        echo "<td>$unClient->email</td>";
                        echo "<td>$unClient->mdp</td>";
                        echo "</tr>";
                    }

                    // Appel pour récupérer le nombre total de clients
                    $nbClients = GestionClient::getNbClients();
                    ?>

                </tbody>

              
                <tfoot>
                    <tr>
                        <td colspan="6" style="text-align: center; font-weight: bold;">
                            <?php echo "Le nombre total de clients est : $nbClients"; ?>
                        </td>
                    </tr>
                </tfoot>

            </table>
        </div>



    </section>
    <br>
    <div class="text-center mb-4">
        <button class="btn btn-dark" data-toggle="modal" data-target="#addClientModal">Ajouter un client</button>
        <button class="btn btn-dark" data-toggle="modal" data-target="#modifyClientModal">Modifier un client</button>
        <button class="btn btn-dark" data-toggle="modal" data-target="#deleteClientModal">Supprimer un client</button>
    </div>


</div>
<br>



<editor-fold defaultstate="collapsed" desc="Modal supprimer client">
    <!-- Modal suppression client -->
    <div class="modal fade" id="deleteClientModal" tabindex="-1" role="dialog" aria-labelledby="deleteClientModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Supprimer un client</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="ClientId">Choisir un client à supprimer</label>
                            <select class="form-control" id="ClientId" name="ClientId" required>
                                <option value="">Sélectionner un client</option>
                                <?php
                                $clients = GestionClient::getLesClients();
                                foreach ($clients as $client) {
                                    echo "<option value=\"{$client->id}\">{$client->nom} - {$client->prenom} - {$client->rue} - {$client->codePostal} - {$client->ville} - {$client->tel} - {$client->email} - {$client->mdp}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-dark">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</editor-fold>

<editor-fold defaultstate="collapsed" desc="Modal ajout client">

    <!-- Modal pour ajouter un client -->
    <div class="modal fade" id="addClientModal" tabindex="-1" role="dialog" aria-labelledby="addClientModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="addClientModal"></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="index.php?controleur=Connexion&action=inscrireClient">
                        <h3 class="text-center mb-4">Formulaire d'ajout de client</h3>
                        <div class="form-container">
                            <div class="form-group">
                                <input type="text" name="prenom" class="form-control" placeholder="Prénom" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="nom" class="form-control" placeholder="Nom" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="ville" class="form-control" placeholder="Ville" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="codePostal" class="form-control" placeholder="Code Postal" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="tel" class="form-control" placeholder="Téléphone" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="rue" class="form-control" placeholder="Rue" required>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="Adresse e-mail" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="mdp" class="form-control" placeholder="Mot de passe" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-dark btn-block">Ajouter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</editor-fold>

<editor-fold defaultstate="collapsed" desc="Modal modifier client">
    <!-- Modal pour modifier un Client -->
    <div class="modal fade" id="modifyClientModal" tabindex="-1" role="dialog" aria-labelledby="modifyClientModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modifyClientModalLabel">Modifier un Client</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="idClient">Choisir un Client à modifier</label>
                            <select class="form-control" id="idClient" name="idClient" onchange="remplirChampsClient()">
                                <option value="">Sélectionner un client</option>
                                <?php
                                foreach ($clients as $client) {
                                    echo "<option value=\"{$client->id}\" 
                                        data-prenom=\"{$client->prenom}\" 
                                        data-nom=\"{$client->nom}\" 
                                        data-rue=\"{$client->rue}\" 
                                        data-code-postal=\"{$client->codePostal}\" 
                                        data-ville=\"{$client->ville}\" 
                                        data-tel=\"{$client->tel}\" 
                                        data-email=\"{$client->email}\" 
                                        data-mdp=\"{$client->mdp}\"> 
                                        {$client->prenom} {$client->nom} - {$client->email}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="newPrenom">Nouveau Prénom</label>
                            <input type="text" class="form-control" id="newPrenom" name="newPrenom" required>
                        </div>
                        <div class="form-group">
                            <label for="newNom">Nouveau Nom</label>
                            <input type="text" class="form-control" id="newNom" name="newNom" required>
                        </div>
                        <div class="form-group">
                            <label for="newRue">Nouvelle Rue</label>
                            <input type="text" class="form-control" id="newRue" name="newRue" required>
                        </div>
                        <div class="form-group">
                            <label for="newCodePostal">Nouveau Code Postal</label>
                            <input type="text" class="form-control" id="newCodePostal" name="newCodePostal" required>
                        </div>
                        <div class="form-group">
                            <label for="newVille">Nouvelle Ville</label>
                            <input type="text" class="form-control" id="newVille" name="newVille" required>
                        </div>
                        <div class="form-group">
                            <label for="newTel">Nouveau Téléphone</label>
                            <input type="text" class="form-control" id="newTel" name="newTel" required>
                        </div>
                        <div class="form-group">
                            <label for="newEmail">Nouvel Email</label>
                            <input type="email" class="form-control" id="newEmail" name="newEmail" required>
                        </div>
                        <div class="form-group">
                            <label for="newMdp">Nouvel mot de passe</label>
                            <input type="text" class="form-control" id="newMdp" name="newMdp" required>
                        </div>
                        <button type="submit" class="btn btn-warning">Modifier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</editor-fold>

<editor-fold defaultstate="collapsed" desc="Vérif formulaire">


    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['ClientId']) && !empty($_POST['ClientId'])) {

            $IdClient = $_POST['ClientId'];
            // Action de suppression
            if (isset($_POST['ClientId'])) {
                $IdClient = $_POST['ClientId'];
                $resultat = GestionClient::supprimerClient($IdClient);
                $message = $resultat ? "Le client a été supprimé avec succès." : "Erreur lors de la suppression du client.";
                header("Location: index.php?controleur=Admin&action=afficherIndex&display=minimal");
            }
        } elseif (isset($_POST['idClient']) && !empty($_POST['idClient'])) {
            // Action de modification
            $id = $_POST['idClient'];
            $prenom = $_POST['newPrenom'];
            $nom = $_POST['newNom'];
            $rue = $_POST['newRue'];
            $codePostal = $_POST['newCodePostal'];
            $ville = $_POST['newVille'];
            $tel = $_POST['newTel'];
            $email = $_POST['newEmail'];
            $mdp = $_POST['newMdp'];

            $resultat = GestionClient::modifierClient($id, $nom, $prenom, $rue, $ville, $codePostal, $tel, $email, $mdp);
            $message = $resultat ? "Le client a été modifié avec succès." : "Erreur lors de la modification du client.";
        }
    }
    ?>

    ?>
</editor-fold>

<script>
function remplirChampsClient() {
    var select = document.getElementById('idClient');
    var selectedOption = select.options[select.selectedIndex];
    
    // Remplir les champs avec les données du client sélectionné
    document.getElementById('newPrenom').value = selectedOption.getAttribute('data-prenom');
    document.getElementById('newNom').value = selectedOption.getAttribute('data-nom');
    document.getElementById('newRue').value = selectedOption.getAttribute('data-rue');
    document.getElementById('newCodePostal').value = selectedOption.getAttribute('data-code-postal');
    document.getElementById('newVille').value = selectedOption.getAttribute('data-ville');
    document.getElementById('newTel').value = selectedOption.getAttribute('data-tel');
    document.getElementById('newEmail').value = selectedOption.getAttribute('data-email');
    document.getElementById('newMdp').value = selectedOption.getAttribute('data-mdp');
}
</script>



<?php
require_once Chemins::VUES_ADMIN . 'v_footerAdmin.php';
?>

<style>
    .client-section {
        padding: 10px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }


    .modal-dialog {
        margin-top: 100px;
    }

    .custom-container {
        margin-left: 20%;
    }

    .text-center {
        text-align: center;
    }
</style>

