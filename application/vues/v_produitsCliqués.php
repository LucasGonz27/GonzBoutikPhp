<div class="product-container">
    <!-- Titre et prix en haut -->
    <div class="product-header">
        <h1>Acheter un <?= htmlspecialchars($produit->nom); ?></h1>
        <p class="price-info">
            À partir de <strong><?= number_format($produit->prix, 2, ',', ' '); ?> €</strong>
            ou <strong><?= number_format($produit->prix / 24, 2, ',', ' '); ?> €/mois</strong> pour 24 mois à 0 % taux débiteur
        </p>
        <p class="sub-info">💡 Conçu pour vous ®</p>
    </div>

    <div class="product-content">
        <!-- Image avec fond gris à gauche -->
        <div class="product-image-container">
            <div class="product-image">
                <img src="<?= Chemins::IMAGES . htmlspecialchars($produit->image); ?>" alt="<?= htmlspecialchars($produit->nom); ?>">
            </div>
        </div>

        <!-- Informations du produit à droite -->
        <div class="product-info">
            <!-- Sélection du modèle -->
            <h2><strong>Modèle.</strong> Quel modèle vous faut-il ?</h2>
            <div class="product-models">
                <div class="model-card">
                    <h3><?= htmlspecialchars($produit->nom); ?></h3>
                    <p>Écran de <?= htmlspecialchars($produit->taille); ?>" pouces</p>
                    <p class="price">À partir de <strong><?= number_format($produit->prix, 2, ',', ' '); ?> €</strong></p>
                    <form method="post" action="index.php?controleur=Produits&action=AjouterProduitPanier&display=minimal" class="d-flex justify-content-left">
                        <div class="form-outline me-1" style="width: 100px;">
                            <input type="number" name="quantite" value="1" class="form-control" />
                        </div>
                        <input type="hidden" name="produit_id" value="<?php echo $produit->id; ?>">
                        <button class="buttonPanier">Ajouter au panier</button>
                    </form>
                </div>

                <div class="model-card">
                    <h3><?= htmlspecialchars($produit->nom); ?> Plus</h3>
                    <p>Écran de <?= htmlspecialchars($produit->taille + 0.6); ?>" pouces</p>
                    <p class="price">À partir de <strong><?= number_format($produit->prix + 150, 2, ',', ' '); ?> €</strong></p>
                    <form method="post" action="index.php?controleur=Produits&action=AjouterProduitPanier&display=minimal" class="d-flex justify-content-left">
                        <div class="form-outline me-1" style="width: 100px;">
                            <input type="number" name="quantite" value="1" class="form-control" />
                        </div>
                        <input type="hidden" name="produit_id" value="<?php echo $produit->id; ?>">
                        <button class="buttonPanier">Ajouter au panier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Infos supplémentaires sous le produit -->
<div class="product-details">

    <h2>Caractéristiques du produit</h2>


    <h3>Description : </h3>
    <p>

        <?= htmlspecialchars($produit->description); ?>

    </p>
    <hr>

    <h3>Stockage : </h3>
    <p>

        <?= htmlspecialchars($produit->stockage); ?>Go

    </p>
    <hr>

    <h3>Taille : </h3>
    <p>
        <?= htmlspecialchars($produit->taille); ?>"

    </p>
    <hr>

    <h3>Couleur : </h3>
    <p>
        <?= htmlspecialchars($produit->couleur); ?>

    </p>
</div>

<?php
require Chemins::VUES_PERMANENTES . 'v_LesIncontournables.inc.php';
?>
<style>
    /* Conteneur principal */

    .buttonPanier {
        background-color: black;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 18px;
       
        cursor: pointer;
        border-radius: 5px;
        margin: 5px;
        margin-top: -5px;
    }

    .buttonPanier:hover {
        background-color: #333;
    }

    body {
        background-color: white;
    }

    .product-container {
        background-color: white;
        padding: 40px;
        max-width: 1200px;
        margin: auto;
    }

    /* Titre et prix en haut */
    .product-header {
        text-align: left;
        margin-bottom: 30px;
    }

    /* Structure en deux colonnes */
    .product-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Image avec fond gris à gauche */
    .product-image-container {
        background-color: #f5f5f7;
        padding: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 20px;
        flex: 1;
        max-width: 90%;
    }

    /* Image responsive */
    .product-image img {
        max-width: 100%;
        height: auto;
    }

    /* Informations du produit à droite */
    .product-info {
        flex: 1;
        padding-left: 40px;
    }

    /* Prix et informations */
    .price-info {
        font-size: 1.2rem;
        color: #333;
    }

    /* Sélection des modèles */
    .product-models {
        background: white;
        padding: 20px;
        border-radius: 10px;
    }

    .model-card {
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 10px;
        transition: 0.3s;
    }

    .model-card:hover {
        background-color: #f5f5f5;
    }

    /* Infos supplémentaires */
    .product-details {
        max-width: 1200px;
        margin: auto;
        padding: 40px;
    }

    .product-details h2 {
        font-size: 1.8rem;
        margin-bottom: 20px;
    }

    .product-details h3 {
        font-size: 1.4rem;
        margin-top: 20px;
    }

    .product-details p {
        font-size: 1.1rem;
        color: #333;
        line-height: 1.6;
    }

    .product-details ul {
        list-style: none;
        padding: 0;
    }

    .product-details ul li {
        font-size: 1.1rem;
        padding: 5px 0;
    }
</style>