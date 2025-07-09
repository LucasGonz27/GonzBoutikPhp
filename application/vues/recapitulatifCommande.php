<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récapitulatif de la commande</title>
    <style>
      

        .containerRecap {
            max-width: 80%;
            margin: 40px auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        h1 {
            text-align: center;
            color: #1d1d1f;
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 30px;
        }

        .commande-info {
            background-color: #f5f5f7;
            padding: 20px;
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .commande-info p {
            margin: 0;
            font-size: 1.1rem;
            color: #86868b;
            display: flex;
            align-items: center;
        }

        .commande-info strong {
            color: #1d1d1f;
            font-weight: 600;
            margin-right: 5px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 30px 0;
        }

        table th {
            background-color: #f5f5f7;
            color: #1d1d1f;
            font-weight: 600;
            padding: 15px;
            text-align: left;
            border-bottom: 2px solid #d2d2d7;
        }

        table td {
            padding: 15px;
            border-bottom: 1px solid #d2d2d7;
            color: #86868b;
        }

        table tr:last-child td {
            border-bottom: none;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
            margin-left: 10px;
        }

        .status-en-attente {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-confirmee {
            background-color: #d4edda;
            color: #155724;
        }

        .status-annulee {
            background-color: #f8d7da;
            color: #721c24;
        }

        .table-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 100%;
        }

        .total-section {
            background-color: #f5f5f7;
            padding: 25px;
            border-radius: 12px;
            text-align: left;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            width: 100%;
        }

        .total-section p {
            font-size: 1.4rem;
            color: #1d1d1f;
            font-weight: 600;
            margin: 0;
        }

        .back-button {
            display: inline-block;
            background-color: black;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: background-color 0.3s ease;
            align-self: flex-start;
        }

        .back-button:hover {
            background-color: #333;
        }

        @media (max-width: 768px) {
            .containerRecap {
                margin: 20px;
                padding: 20px;
            }

            h1 {
                font-size: 2rem;
            }

            table {
                display: block;
                overflow-x: auto;
            }

            .commande-info p {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="containerRecap">
        <h1>Récapitulatif de votre commande</h1>

        <?php if ($commande): ?>
            <div class="commande-info">
                <p><strong>Commande N°:</strong> <?php echo $commande['id']; ?></p>
                <p><strong>Date de la commande:</strong> <?php echo $commande['date']; ?></p>
                <p><strong>Statut de la commande:</strong> 
                    <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $commande['statut'])); ?>">
                        <?php echo $commande['statut']; ?>
                    </span>
                </p>
            </div>

            <?php if ($lignesCommande): ?>
                <h2>Détails des produits</h2>
                <table>
                    <tr>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Prix Unitaire</th>
                        <th>Sous-Total</th>
                    </tr>
                    <?php foreach ($lignesCommande as $ligne): ?>
                        <tr>
                            <td>
                                <?php 
                                $produit = GestionProduit::getProduitById($ligne->idProduit);
                                if ($produit) {
                                    echo '<img src="' . Chemins::IMAGES . htmlspecialchars($produit->image) . '" alt="Image du produit" style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">';
                                } else {
                                    echo 'Image non disponible';
                                }
                                ?>
                            </td>
                            <td><?php echo $ligne->quantite; ?></td>
                            <td><?php echo number_format($ligne->prixUnitaire, 2, ',', ' '); ?> €</td>
                            <td><?php echo number_format($ligne->sousTotal, 2, ',', ' '); ?> €</td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>Aucune ligne de commande trouvée.</p>
            <?php endif; ?>

            <div class="total-section">
                <p><strong>Total de la commande:</strong> <?php echo number_format($commande['total'], 2, ',', ' '); ?> €</p>
            </div>

            <div class="payment-options">
                <div class="payment-title">Méthode de paiement</div>
                <div class="payment-method">
                    <input type="radio" id="paypal" name="payment_method" value="paypal" checked>
                    <label for="paypal">PayPal Sandbox</label>
                    <img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_37x23.jpg" alt="PayPal">
                </div>
            </div>

            <!-- Formulaire PayPal Sandbox -->
            <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_xclick">
                <input type="hidden" name="business" value="lucas.gonz2702@gmail.com">
                <input type="hidden" name="item_name" value="Commande GonzBoutiK">
                <input type="hidden" name="amount" value="<?php echo $commande['total']; ?>">
                <input type="hidden" name="currency_code" value="EUR">
                <input type="hidden" name="return" value="http://votre-site.com/success.php">
                <input type="hidden" name="cancel_return" value="http://votre-site.com/cancel.php">
                <input type="hidden" name="notify_url" value="http://votre-site.com/ipn.php">
                <button type="submit" class="buttonRecap">Payer avec PayPal</button>
            </form>

        <?php else: ?>
            <p>Commande non trouvée.</p>
        <?php endif; ?>

        <a href="index.php?controleur=Panier&action=index" class="back-button">Retour à mon panier</a>
    </div>
</body>
</html>

