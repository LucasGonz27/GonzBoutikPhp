<div class="container">
    <h1>Résultats de la recherche<?php 
        if (isset($_GET['recherche']) && !empty($_GET['recherche'])) {
            echo ' pour <strong>"' . htmlspecialchars($_GET['recherche']) . '"</strong>';
        }
    ?></h1>

    <div class="produits-container">
        <?php
        if (!empty($resultats)) {
            foreach ($resultats as $unProduit) { ?>
                <div class="produit-card">
                    <div class="produit-image">
                        <img src="<?php echo Chemins::IMAGES . $unProduit['image']; ?>" 
                             alt="<?php echo htmlspecialchars($unProduit['nom']); ?>" class="img-fluid">
                    </div>
                    <div class="produit-details">
                        <h5 class="produit-title"><?php echo htmlspecialchars($unProduit['nom']); ?></h5>
                        <p class="produit-description"><?php echo nl2br(htmlspecialchars($unProduit['description'])); ?></p>
                        <p class="produit-price">À partir de <strong><?php echo htmlspecialchars($unProduit['prix']); ?> €</strong></p>
                        <div class="produit-buttons">
                            <a href="index.php?controleur=Produits&action=AfficherProduitCliques&id=<?php echo $unProduit['id']; ?>" class="btn-details">En savoir plus</a>
                            <a href="index.php?controleur=Produits&action=AfficherProduitCliques&id=<?php echo $unProduit['id']; ?>" class="btn-buy">Acheter ></a>
                        </div>
                    </div>
                </div>
            <?php } 
        } else { ?>
            <p>Aucun produit trouvé pour votre recherche.</p>
        <?php } ?>
    </div>
</div> <br><br><br>

<!-- Styles personnalisés -->
<style>
    .container {
        max-width: 100%;
        margin: 0 auto;
        padding: 5px;
        text-align: center;
    }

    h1 {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 40px;
        text-align: left;
    }

    .produits-container {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .produit-card {
        width: 300px;

        margin-bottom: 20px;
    }

    .produit-image img {
        height: auto;
        display: block;
        transition: transform 0.3s ease-in-out;
    }

    .produit-card:hover .produit-image img {
        transform: scale(1.1);
    }

    .produit-title {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .produit-description {
        font-size: 1rem;
        margin-bottom: 11px;
    }

    .produit-price {
        font-size: 1.2rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 15px;
    }

    .produit-buttons {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .btn-details, .btn-buy {
        padding: 10px 20px;
        border-radius: 25px;
        font-size: 1rem;
        text-decoration: none;
        font-weight: bold;
        display: inline-block;
        transition: background-color 0.3s, transform 0.2s;
    }

    .btn-details {
        background-color: #0071e3;
        color: white;
    }

    .btn-buy {
        color: #1572cf;
    }


</style>
