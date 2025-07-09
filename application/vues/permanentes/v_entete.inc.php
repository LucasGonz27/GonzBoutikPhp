<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GonzBoutik</title>

    <link href="<?php echo Chemins::STYLES . 'style.css'; ?>" rel="stylesheet">
    <link href="<?php echo Chemins::STYLES . 'bootstrap-utilities.min.css'; ?>" rel="stylesheet">
    <script src="<?php echo Chemins::JS . 'script.js'; ?>"></script>
    <script src="https://kit.fontawesome.com/a2cccffcf0.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <!-- Icônes FontAwesome (déjà inclus ci-dessus, donc à supprimer dupliqué) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>


<?php
// Vérifier si le panier est vide
Panier::initialiser();
$produitsPanier = Panier::getProduits();
$isPanierVide = empty($produitsPanier);
?>

<body>
    <!-- Barre de navigation -->
    <header>
        <nav>
            <div class="nav-left">
                <div class="logo">
                    <a class="navbar-brand p-1" href="index.php?cas=afficherAccueil">
                        <img src="<?php echo Chemins::IMAGES . 'Logo.png'; ?>" alt="Apple">
                    </a>
                </div>
            </div>
            <ul class="nav-menu">
                <?php
                // Vérifie que la variable contient des marques
                $lesMarques = GestionMarque::getLesMarques();
                foreach ($lesMarques as $uneMarque) {
                    echo '<li><a href="index.php?controleur=Produits&action=afficher&marque=' . htmlspecialchars($uneMarque->nom) . '">' . htmlspecialchars($uneMarque->nom) . '</a></li>';
                }
                ?>
            </ul>
            <div class="nav-right">
                <i class="fa fa-search search-icon"></i>

                <?php if (isset($_SESSION['login_client'])): ?>
                    <!-- Si l'utilisateur est connecté -->
                    <a href="index.php?controleur=Connexion&action=afficherCompteClient">
                        <i class="fa fa-user"></i>
                    </a>
                <?php else: ?>
                    <!-- Si l'utilisateur n'est pas connecté -->
                    <a href="index.php?controleur=Connexion&action=afficherCompteClient">
                        <i class="fa fa-user"></i>
                    </a>
                <?php endif; ?>


                <?php if (!$isPanierVide): ?>
                    <a href="index.php?controleur=Produits&action=afficherPanier">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </a>
                <?php endif; ?>

                <button id="menuToggle" class="menu-btn">
                    <i class="fas fa-bars"></i>
                </button>
            </div>


        </nav>
    </header>

    <!-- Fond flou pour la recherche -->
    <div class="search-overlay"></div>

    <!-- Overlay de recherche -->
    <div class="search-overlay" id="searchOverlay">
        <div class="search-container">
            <form class="" role="search" method="GET" action="index.php?controleur=Produits&action=rechercherProduits">
                <!-- Champs cachés pour le controleur et l'action -->
                <input type="hidden" name="controleur" value="Produits">
                <input type="hidden" name="action" value="rechercherProduits">
                <input type="search" name="recherche" class="search-input" id="barreRecherche" placeholder="Rechercher..." aria-label="Recherche" autocomplete="off">
                <!-- Bouton de soumission -->
                <button type="submit" style="border: none; background: transparent;">
                    <i class="fa fa-search search-icon"></i>
                </button>
            </form>
        </div>
        <ul class="quick-links">
            <p>Liens rapides</p>
            <li><a href="#"> → Trouver un magasin</a></li>
            <li><a href="#"> → Apple Vision Pro</a></li>
            <li><a href="#"> → AirPods</a></li>
            <li><a href="#"> → AirTag</a></li>
            <li><a href="#"> → Apple Trade In</a></li>
        </ul>
        <button class="close-search" id="closeSearch"></button>
    </div>

    <!-- Menu mobile (caché par défaut) -->
    <div id="mobileMenu" class="mobile-menu">
        <button class="close-menu" id="closeMenu"></button>
        <ul>
            <li>Store</li>
            <li>Samsung</li>
            <li>Honor</li>
            <li>iPhone</li>
            <li>Xiaomi</li>
            <li>Wiko</li>
            <li>Google</li>
            <li>Sonny</li>
            <li>Oppo</li>
            <li>Huawei</li>
        </ul>
    </div>

    <div class="announcement">
        Jusqu'au 2 avril, bénéficiez d’une meilleure valeur de reprise pour l’achat
        d’un nouvel iPhone.
        <a href="#">Acheter un iPhone</a>
    </div>

    <style>.nav-right a {
    color: black !important; /* Force la couleur noire */
    text-decoration: none; /* Supprime le soulignement */
}

.nav-right a:visited {
    color: #1d1d1f !important; /* Évite le violet sur les liens visités */
}

.nav-right a:hover {
    color:  #1d1d1f !important; /* Empêche tout changement de couleur au survol */
}

.nav-right a i {
    color:  #1d1d1f !important; /* Assure que l'icône reste noire */
}
</style>