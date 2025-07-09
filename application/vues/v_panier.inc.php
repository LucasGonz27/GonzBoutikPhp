<?php


// Récupérer les produits du panier
$produitsPanier = Panier::getProduits();
$prixTotal = 0;
$nombreProduits = 0;

// Calculer le nombre total de produits
foreach ($produitsPanier as $quantite) {
    $nombreProduits += $quantite;
}

echo '<div class="panier-page">';

// Colonne Produits
echo '<div class="produits-container">';
echo '<h2>Mon Panier (<span id="nombre-produits">' . $nombreProduits . '</span> produit' . ($nombreProduits > 1 ? 's' : '') . ')</h2>'; // Affiche le nombre de produits

if (empty($produitsPanier)) {
    // Affichage du message si le panier est vide
    echo '<p class="panier-vide">Votre panier est vide.</p>';
} else {
    foreach ($produitsPanier as $idProduit => $quantite) {
        $produit = GestionProduit::getProduitById($idProduit);
        $prixTotalProduit = $produit->prix * $quantite;
        $prixTotal += $prixTotalProduit;

        // Affichage d'un produit
        echo '<div class="produit-item" data-id="' . $idProduit . '" data-prix="' . $produit->prix . '">';
        echo '<img src="' . Chemins::IMAGES . htmlspecialchars($produit->image) . '" alt="Image de ' . htmlspecialchars($produit->nom) . '" class="produit-image">';
        echo '<div class="produit-details">';
        echo '<h3>' . htmlspecialchars($produit->nom) . '</h3>';
        echo '<p>Garantie 24 mois</p>';
        echo '<p class="prix" id="prix-' . $idProduit . '">' . number_format($produit->prix, 2, ',', ' ') . ' €</p>';
        echo '<div class="actions">';
        echo '<label for="quantite-' . $idProduit . '">Quantité :</label>';
        echo '<select class="quantite" name="quantite" id="quantite-' . $idProduit . '" required>';

        for ($i = 1; $i <= 10; $i++) {
            $selected = ($i == $quantite) ? 'selected' : '';
            echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
        }
        echo '</select>';
        echo '</div>';

        // Bouton de suppression
        echo '<form method="POST" action="index.php?controleur=Panier&action=retirerProduit">';
        echo '<input type="hidden" name="produit_id" value="' . $idProduit . '">';
        echo '<button type="submit" class="btn-supprimer">Supprimer</button>';
        echo '</form>';

        echo '</div>';
        echo '</div>';
    }
    ?>
    <form method="POST" action="index.php?controleur=Panier&action=viderPanier">
    <button type="submit" class="btn-vider">Vider le panier</button>
    
    </form>
<?php

}
echo '</div>'; // Fermeture de produits-container

// Colonne Récapitulatif
echo '<div class="recap-container">';
echo '<h3>Récapitulatif</h3>';
echo '<p>Frais de livraison : <span class="frais">Gratuits</span></p>';
echo '<h4>Total : <span class="total" id="prix-total">' . number_format($prixTotal, 2, ',', ' ') . ' €</span></h4>';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['login_client'])) {
    echo '<div class="alert alert-warning" style="background-color: #fff3cd; color: #856404; padding: 10px; border-radius: 5px; margin-bottom: 15px;">';
    echo 'Vous devez être connecté pour passer une commande.';
    echo '</div>';
    echo '<a href="index.php?controleur=Connexion&action=afficherCompteClient" class="btn-commander">Se connecter</a>';
} else {
    echo '<form method="POST" action="index.php?controleur=Panier&action=validerCommande">';
    echo '<input type="hidden" name="total" value="' . $prixTotal . '">';
    echo '<button type="submit" class="btn-commander">Commander</button>';
    echo '</form>';
}

echo '</div>'; // Fermeture de recap-container
echo '</div>'; // Fermeture de panier-page
?>

<script>
    // Fonction pour recalculer le nombre total de produits
    function recalculerNombreProduits() {
        let totalProduits = 0;

        // Pour chaque produit dans le panier, on ajoute sa quantité au total
        document.querySelectorAll('.quantite').forEach(select => {
            totalProduits += parseInt(select.value); // Ajoute la quantité
        });

        // Met à jour le nombre de produits affiché
        document.getElementById('nombre-produits').innerText = totalProduits;
    }

    // Fonction pour recalculer le total à chaque changement de quantité
    function recalculerTotal() {
        let total = 0;

        // Pour chaque produit dans le panier, on met à jour son prix
        document.querySelectorAll('.produit-item').forEach(item => {
            const prixUnitaire = parseFloat(item.dataset.prix); // Récupère le prix unitaire
            const quantite = parseInt(item.querySelector('.quantite').value); // Récupère la quantité
            const prixProduit = prixUnitaire * quantite; // Calcule le prix total

            // Met à jour le prix affiché pour ce produit
            item.querySelector('.prix').innerText = prixProduit.toFixed(2) + ' €';

            // Ajoute ce prix au total
            total += prixProduit;
        });

        // Met à jour le prix total global
        document.getElementById('prix-total').innerText = total.toFixed(2) + ' €';
    }

    // Écoute les changements de quantité et met à jour le nombre total de produits et le total
    document.querySelectorAll('.quantite').forEach(select => {
        select.addEventListener('change', function() {
            recalculerNombreProduits(); // Met à jour le nombre total de produits
            recalculerTotal(); // Recalcule le total
        });
    });

    // Recalcul dès le chargement de la page
    recalculerNombreProduits();
    recalculerTotal();
</script>


<style>
    .btn-vider {
        background-color: black;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
    }

    .btn-vider:hover {
        background-color: black;
    }


    /* Style général pour la page du panier */
    .panier-page {
        display: flex;
        justify-content: space-between;
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    /* Colonne gauche : Produits */
    .produits-container {
        flex: 2;
        margin-right: 20px;
    }

    .produits-container h2 {
        font-size: 1.8rem;
        color: #333;
        margin-bottom: 20px;
    }

    .produit-item {
        display: flex;
        align-items: flex-start;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .produit-image {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 15px;
    }

    .produit-details {
        flex: 1;
    }

    .produit-details h3 {
        font-size: 1.2rem;
        color: #333;
        margin-bottom: 5px;
    }

    .produit-details p {
        margin: 5px 0;
        font-size: 0.9rem;
        color: #666;
    }

    .produit-details .prix {
        font-size: 1.1rem;
        font-weight: bold;
        color: black;
    }

    .actions {
        display: flex;
        align-items: center;
        margin-top: 10px;
    }

    .actions label {
        margin-right: 10px;
        font-size: 0.9rem;
        color: #555;
    }

    .actions select {
        padding: 5px;
        font-size: 0.9rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-right: 10px;
    }

    .btn-supprimer {
        background-color: black;
        color: white;
        padding: 8px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-left: auto;
        /* Cette ligne va pousser le bouton vers la droite */
        display: block;
        /* Assurez-vous que le bouton est un bloc pour appliquer margin-left */
    }

    .btn-supprimer:hover {
        background-color: black;
    }



    .livraison-options {
        margin-top: 15px;
    }

    .livraison-btn {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #f9f9f9;
        cursor: pointer;
        font-size: 0.9rem;
        margin-right: 10px;
    }

    .livraison-btn.actif {
        border-color: #007bff;
        color: #007bff;
        background-color: #eef5ff;
    }

    /* Colonne droite : Récapitulatif */
    .recap-container {
        flex: 1;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #ddd;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .recap-container h3 {
        font-size: 1.5rem;
        color: #333;
        margin-bottom: 20px;
        text-align: center;
    }

    .recap-container p {
        font-size: 1rem;
        margin: 10px 0;
        color: #555;
    }



    .recap-container .frais {
        color: #007bff;
        font-weight: bold;
    }

    .recap-container .total {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
        text-align: center;
        display: block;
        margin-top: 20px;
    }

    .btn-commander {
        display: block;
        width: 100%;
        padding: 15px 0;
        background-color: black;
        color: white;
        text-align: center;
        font-size: 1.2rem;
        font-weight: bold;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        margin-top: 20px;
        text-decoration: none;
    }

   
</style>