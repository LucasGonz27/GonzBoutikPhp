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
            <h2 class="text-center mb-4">Tableau des Marques</h2>
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th scope="col">Nom</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $Marques = GestionMarque::getLesMarques();
                    foreach ($Marques as $uneMarque) {
                        echo "<tr>";
                        echo "<td>$uneMarque->nom</td>";
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
        <button class="btn btn-primary" data-toggle="modal" data-target="#addClientModal">Ajouter une marque</button>
        <button class="btn btn-secondary" data-toggle="modal" data-target="#modifyClientModal">Modifier une marque</button>
        <button class="btn btn-danger" data-toggle="modal" data-target="#deleteClientModal">Supprimer une marque</button>
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