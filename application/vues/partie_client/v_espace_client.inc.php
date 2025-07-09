<script>
    // Fonction pour afficher une section spécifique
    function showContent(sectionId) {
        const sections = document.querySelectorAll('.content-section');
        sections.forEach(section => {
            section.style.display = section.id === sectionId ? 'block' : 'none';
        });

        // Activer l'élément de la barre latérale
        const links = document.querySelectorAll('.sidebar ul li a');
        links.forEach(link => {
            link.parentElement.classList.remove('active');
        });
        document.querySelector(`[onclick="showContent('${sectionId}')"]`).parentElement.classList.add('active');
    }
</script>

<style>

.container-client {
    display: flex;
    max-width: 1200px;
    margin: 40px auto;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

/* Barre latérale */
.sidebar {
    width: 260px;
    background: #f8f8f8;
    padding: 20px;
    border-right: 1px solid #e0e0e0;
}

.sidebar ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar ul li {
    margin-bottom: 15px;
}

.sidebar ul li a {
    text-decoration: none;
    color: #333;
    font-size: 16px;
    padding: 12px;
    display: block;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.sidebar ul li a:hover,
.sidebar ul li.active a {
    background: #e5e5ea;
    color: #000;
}

/* Contenu principal */
.main-content {
    flex: 1;
    padding: 30px;
    border-radius: 10px;
}

/* Boîte d'information */
.info-box {
    background: #f8f8f8;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.info-box h3 {
    margin-bottom: 10px;
}





.deco {
    margin-left: 50px;
}

.deco button {
    background:rgb(0, 0, 0);
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 14px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.deco button:hover {
    background:rgb(75, 69, 69);
}

/* Sections cachées */
.content-section {
    display: none;
}

.content-section.active {
    display: block;
}

/* Style pour les commandes */
.commandes-list {
    margin-top: 20px;
}

.commande-item {
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    margin-bottom: 20px;
    padding: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.commande-header {
    border-bottom: 1px solid #e0e0e0;
    padding-bottom: 15px;
    margin-bottom: 15px;
}

.commande-header h3 {
    margin: 0;
    color: #333;
}

.commande-header p {
    margin: 5px 0;
    color: #666;
}

.commande-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

.commande-table th,
.commande-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #e0e0e0;
}

.commande-table th {
    background-color: #f8f8f8;
    font-weight: bold;
}

.commande-table tfoot {
    font-weight: bold;
}

.commande-table tfoot td {
    border-top: 2px solid #e0e0e0;
}

/* Style pour le bouton de facture */
.commande-actions {
    margin-top: 20px;
    text-align: right;
}

.btn-facture {
    display: inline-block;
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.btn-facture:hover {
    background-color: #0056b3;
}

.btn-facture i {
    margin-right: 5px;
}

</style>



<div class="container-client">
    <!-- Barre latérale -->
    <nav class="sidebar">
        <ul>
            <li class="active"><a href="#" onclick="showContent('home')">Accueil</a></li>
            <li><a href="#" onclick="showContent('commands')">Mes commandes</a></li>
            <li><a href="#" onclick="showContent('profile')">Mon profil</a></li>
        </ul>
    </nav>

    <!-- Contenu principal -->
    <main class="main-content">
        <!-- Accueil -->
        <section id="home" class="content-section">
            <h1>Bienvenue <?php echo $prenom; ?> dans votre espace client</h1>
            <p>Veuillez sélectionner une option dans le menu.</p>
        </section>

        <!-- Mes commandes -->
        <section id="commands" class="content-section" style="display: none;">
            <h1>Mes commandes</h1>
            <?php
            $email = $_SESSION['login_client'];
            $client = GestionClient::getClientParEmail($email);
            $commandes = GestionCommande::getCommandesByClient($client);
            
            if ($commandes) {
                foreach ($commandes as $commande) {
                    echo '<div class="commande-item">';
                    echo '<div class="commande-header">';
                    echo '<h3>Commande #' . $commande->id . '</h3>';
                    echo '<p>Date : ' . date('d/m/Y', strtotime($commande->date)) . '</p>';
                    echo '<p>Statut : ' . $commande->statut . '</p>';
                    echo '</div>';
                    
                    // Récupérer les lignes de commande
                    $lignesCommande = GestionCommande::getLignesDeCommande($commande->id);
                    
                    echo '<div class="commande-details">';
                    echo '<table class="commande-table">';
                    echo '<thead><tr>';
                    echo '<th>Produit</th>';
                    echo '<th>Quantité</th>';
                    echo '<th>Prix unitaire</th>';
                    echo '<th>Sous-total</th>';
                    echo '</tr></thead>';
                    echo '<tbody>';
                    
                    foreach ($lignesCommande as $ligne) {
                        $produit = GestionProduit::getProduitById($ligne->idProduit);
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($produit->nom) . '</td>';
                        echo '<td>' . $ligne->quantite . '</td>';
                        echo '<td>' . number_format($ligne->prixUnitaire, 2, ',', ' ') . ' €</td>';
                        echo '<td>' . number_format($ligne->sousTotal, 2, ',', ' ') . ' €</td>';
                        echo '</tr>';
                    }
                    
                    echo '</tbody>';
                    echo '<tfoot>';
                    echo '<tr><td colspan="3"><strong>Total</strong></td>';
                    echo '<td><strong>' . number_format($commande->total, 2, ',', ' ') . ' €</strong></td></tr>';
                    echo '</tfoot>';
                    echo '</table>';
                    echo '</div>';
                    // Ajout du bouton de téléchargement de facture
                    echo '<div class="commande-actions">';
                    echo '<a href="index.php?controleur=Commande&action=telechargerFacture&idCommande=' . $commande->id . '" class="btn-facture">';
                    echo '<i class="fas fa-download"></i> Télécharger la facture';
                    echo '</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>Aucune commande trouvée.</p>';
            }
            ?>
        </section>

        <!-- Mon profil -->
        <section id="profile" class="content-section" style="display: none;">
            <h1>Mes données personnelles</h1>
            <p>Mes données personnelles me permettent de visualiser et de modifier toutes mes informations personnelles :</p>
            <div class="info-box">
                <h3>Mes coordonnées</h3>
                <label>Email :</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <br><br>

                <label>Téléphone :</label>
                <input type="text" name="tel" value="<?php echo htmlspecialchars($tel); ?>">
                <br>

                <label>Rue :</label>
                <input type="text" name="rue" value="<?php echo htmlspecialchars($rue); ?>">
                <br>
                <label>Code Postal :</label>
                <input type="text" name="codePostal" value="<?php echo htmlspecialchars($codePostal); ?>">
                <br>
                <label>Ville :</label>
                <input type="text" name="ville" value="<?php echo htmlspecialchars($ville); ?>">
                <br>
                <a href="#" class="modify-link">Modifier</a>
            </div>

            <div class="info-box">
                <h3>Mon mot de passe</h3>
                <p>Mot de passe : <?php echo htmlspecialchars($mdp); ?>
                <p>
                    <a href="#" class="modify-link">Modifier</a>
            </div>
        </section>
    </main>
</div><br>
<div class="deco">
    <a href="index.php?controleur=Connexion&action=seDeconnecter">
        <button>Se déconnecter (<?php echo htmlspecialchars($_SESSION['login_client']); ?>)</button>
    </a>
</div>
<br><br>
