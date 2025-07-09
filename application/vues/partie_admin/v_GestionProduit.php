<?php
require_once Chemins::VUES_ADMIN . 'v_enteteAdmin.php'; // Entête de la page
require_once Chemins::VUES_ADMIN . 'v_menuGaucheAdmin.php'; // Menu latéral
?>
<br><br><br><br>
<!-- Conteneur central -->
<div class="container my-5-bloc">
  

    <!-- Section des clients -->
    <section class="client-section mb-5">
        <h2 class="text-center mb-4"><i class="fas fa-boxes"></i> Tableau des produits</h2>
        <table class="table table-striped table-hover text-center table-bordered produit-table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Description</th>
                    <th scope="col">Prix</th>
                    <th scope="col">Couleur</th>
                    <th scope="col">Stockage</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Taille</th>
                    <th scope="col">Catégorie</th>
                    <th scope="col">Marque</th>
                    <th scope="col">Fournisseur</th>
                    <th scope="col">Image</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $Produits = GestionProduit::getLesProduits();
                foreach ($Produits as $unProduit) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($unProduit->nom) . "</td>";
                    echo "<td>" . htmlspecialchars($unProduit->description) . "</td>";
                    echo "<td>" . htmlspecialchars($unProduit->prix) . " €</td>";
                    echo "<td>" . htmlspecialchars($unProduit->couleur) . "</td>";
                    echo "<td>" . htmlspecialchars($unProduit->stockage) . "</td>";
                    echo "<td>" . htmlspecialchars($unProduit->stock) . "</td>";
                    echo "<td>" . htmlspecialchars($unProduit->taille) . "</td>";
                    echo "<td>" . htmlspecialchars($unProduit->idCategorie) . "</td>";
                    echo "<td>" . htmlspecialchars($unProduit->idMarque) . "</td>";
                    echo "<td>" . htmlspecialchars($unProduit->idFournisseur) . "</td>";
                    echo "<td><img src='./images/" . htmlspecialchars($unProduit->image) . "' alt='" . htmlspecialchars($unProduit->nom) . "' style='max-width:60px;max-height:60px;border-radius:8px;box-shadow:0 2px 6px rgba(0,0,0,0.08);'></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <div class="text-center mb-5">
        <button class="btn btn-success mx-2" data-toggle="modal" data-target="#addClientModal"><i class="fas fa-plus"></i> Ajouter un produit</button>
        <button class="btn btn-warning mx-2" data-toggle="modal" data-target="#modifyClientModal"><i class="fas fa-edit"></i> Modifier un produit</button>
        <button class="btn btn-danger mx-2" data-toggle="modal" data-target="#deleteClientModal"><i class="fas fa-trash"></i> Supprimer un produit</button>
    </div>
</div>

<?php
require_once Chemins::VUES_ADMIN . 'v_footerAdmin.php'; // Pied de page
?>

<!-- FontAwesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
body {
    background: #f4f6fb;
}
.container.my-5-bloc {
    margin-top: 40px;
    margin-bottom: 40px;
}
.client-section, .top-produits-section {
    padding: 30px 20px 20px 20px;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    margin-bottom: 40px;
}
.client-section h2, .top-produits-section h3 {
    font-size: 2rem;
    font-weight: 700;
    letter-spacing: 1px;
}
.produit-table th, .produit-table td {
    vertical-align: middle;
}
.produit-table thead {
    background: #007bff;
    color: #fff;
}
.produit-table tbody tr:hover {
    background: #e3f2fd;
}
.top-produits-section .card {
    border-radius: 15px;
}
.top-produits-section .card-header {
    border-radius: 15px 15px 0 0;
    background: linear-gradient(90deg, #007bff 60%, #00c6ff 100%);
}
.top-produits-section table th, .top-produits-section table td {
    vertical-align: middle;
    font-size: 1.1em;
}
.top-produits-section .badge-success {
    background: linear-gradient(90deg, #28a745 60%, #a8e063 100%);
    color: #fff;
    font-weight: 600;
}
.btn {
    font-size: 1.1em;
    padding: 10px 22px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
    transition: background 0.2s, color 0.2s;
}
.btn-success {
    background: linear-gradient(90deg, #28a745 60%, #a8e063 100%);
    border: none;
}
.btn-warning {
    background: linear-gradient(90deg, #ffc107 60%, #ffe082 100%);
    border: none;
    color: #333;
}
.btn-danger {
    background: linear-gradient(90deg, #dc3545 60%, #ff758c 100%);
    border: none;
}
.btn-success:hover, .btn-warning:hover, .btn-danger:hover {
    filter: brightness(0.95);
    color: #fff;
}
</style>