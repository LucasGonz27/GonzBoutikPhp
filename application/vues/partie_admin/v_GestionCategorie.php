<?php
require_once Chemins::VUES_ADMIN . 'v_enteteAdmin.php'; // Entête de la page
require_once Chemins::VUES_ADMIN . 'v_menuGaucheAdmin.php'; // Menu latéral
?>
<br><br><br><br><br>
<!-- Conteneur central -->
<div class="container my-5-bloc">
   

    <!-- Section des clients -->
    <section class="client-section">
        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
            <h2 class="text-center mb-4">Tableau des clients</h2>
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Rue</th>
                        <th scope="col">Code postal</th>
                        <th scope="col">Ville</th>
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
                        echo "<td>$unClient->rue</td>";
                        echo "<td>$unClient->codePostal</td>";
                        echo "<td>$unClient->ville</td>";
                        echo "<td>$unClient->tel</td>";
                        echo "<td>$unClient->email</td>";
                        echo "<td>$unClient->mdp</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</div>
<br>
<div class="text-center mb-4">
        <button class="btn btn-primary" data-toggle="modal" data-target="#addClientModal">Ajouter un client</button>
        <button class="btn btn-secondary" data-toggle="modal" data-target="#modifyClientModal">Modifier un client</button>
        <button class="btn btn-danger" data-toggle="modal" data-target="#deleteClientModal">Supprimer un client</button>
    </div>

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
                                echo "<option value=\"{$client->id}\">{$client->nom} - {$client->prenom} - {$client->rue} - {$client->codePostal} - {$client->tel} - {$client->email} - {$client->mdp}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once Chemins::VUES_ADMIN . 'v_footerAdmin.php'; // Pied de page
?>

<style>
.client-section {
    padding: 20px;
    background-color: #f9f9f9; 
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Effet d'ombre douce */
}

.client-section h2 {
    font-size: 24px;
    font-weight: bold;
}




</style>