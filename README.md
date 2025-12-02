# GonzBoutik V9

Application e-commerce PHP pour la vente de smartphones, développée avec une architecture MVC (Modèle-Vue-Contrôleur).

## 📋 Description

GonzBoutik est une boutique en ligne spécialisée dans la vente de smartphones. L'application permet aux clients de parcourir le catalogue de produits, gérer leur panier, passer des commandes, tandis que les administrateurs peuvent gérer les produits, les commandes et les clients via un panneau d'administration.

## 🚀 Fonctionnalités

### Partie Client
- **Catalogue de produits** : Affichage des smartphones avec filtres par catégorie et marque
- **Recherche de produits** : Recherche par nom, marque ou caractéristiques
- **Gestion du panier** : Ajout, modification et suppression d'articles
- **Authentification** : Inscription et connexion des clients
- **Commandes** : Passage de commande et suivi
- **Récapitulatif de commande** : Visualisation des détails de commande

### Partie Administrateur
- **Gestion des produits** : Ajout, modification et suppression de produits
- **Gestion des catégories et marques** : Administration du catalogue
- **Gestion des commandes** : Suivi et traitement des commandes
- **Gestion des clients** : Consultation et gestion des comptes clients
- **Génération de PDF** : Export de documents (via TCPDF)

## 🛠️ Technologies utilisées

- **Backend** : PHP (POO, PDO)
- **Base de données** : MySQL
- **Architecture** : MVC (Modèle-Vue-Contrôleur)
- **Frontend** : HTML, CSS, JavaScript, Bootstrap
- **Bibliothèques** :
  - TCPDF (génération de PDF)
  - jQuery
  - Bootstrap
  - ApexCharts (graphiques)

## 📁 Structure du projet

```
GonzBoutikV9/
├── application/
│   ├── controleurs/          # Contrôleurs MVC
│   │   ├── ControleurAdmin.class.php
│   │   ├── ControleurCategorieMarques.class.php
│   │   ├── ControleurCommande.class.php
│   │   ├── ControleurConnexion.class.php
│   │   ├── ControleurPanier.class.php
│   │   └── ControleurProduits.class.php
│   ├── modeles/              # Modèles de données
│   │   ├── gestionBoutique.class.php
│   │   ├── gestionCategorie.class.php
│   │   ├── gestionClient.class.php
│   │   ├── gestionCommande.class.php
│   │   ├── gestionFournisseur.class.php
│   │   ├── gestionMarque.class.php
│   │   ├── gestionProduit.class.php
│   │   ├── ModelePdo.class.php
│   │   └── Panier.class.php
│   └── vues/                 # Vues (templates)
│       ├── partie_admin/     # Vues administration
│       ├── partie_client/    # Vues client
│       ├── permanentes/       # En-tête, pied de page
│       ├── v_accueil.inc.php
│       ├── v_panier.inc.php
│       ├── v_produits.inc.php
│       └── ...
├── configs/                  # Configuration
│   ├── chemins.class.php     # Chemins de l'application
│   ├── mysql_config.class.php # Configuration MySQL
│   ├── variables_globales.class.php
│   ├── gonzalez_boutique.sql  # Script SQL de la base de données
│   └── tcpdf/                # Bibliothèque TCPDF
├── public/                   # Ressources publiques
│   ├── css/                  # Feuilles de style
│   ├── js/                   # Scripts JavaScript
│   └── images/               # Images des produits
└── index.php                 # Point d'entrée de l'application
```

## ⚙️ Installation

### Prérequis

- **Serveur web** : WAMP, XAMPP, LAMP ou MAMP
- **PHP** : Version 7.4 ou supérieure
- **MySQL** : Version 5.7 ou supérieure
- **Extensions PHP** : PDO, PDO_MySQL, mbstring

### Étapes d'installation

1. **Cloner ou télécharger le projet**
   ```bash
   git clone [url-du-repo]
   cd GonzBoutikV9
   ```

2. **Configurer la base de données**
   - Créer une base de données MySQL nommée `gonzalez_boutique`
   - Importer le script SQL : `configs/gonzalez_boutique.sql`
   - Vous pouvez utiliser phpMyAdmin ou la ligne de commande :
     ```bash
     mysql -u root -p < configs/gonzalez_boutique.sql
     ```

3. **Configurer les paramètres de connexion**
   - Éditer le fichier `configs/mysql_config.class.php` :
   ```php
   class MysqlConfig {
       const SERVEUR = 'localhost';
       const BASE = 'gonzalez_boutique';
       const UTILISATEUR = 'votre_utilisateur';
       const MOT_DE_PASSE = 'votre_mot_de_passe';
   }
   ```

4. **Configurer le serveur web**
   - Si vous utilisez WAMP/XAMPP, placer le projet dans le dossier `www` ou `htdocs`
   - L'URL d'accès sera : `http://localhost/GonzBoutikV9/`

5. **Vérifier les permissions**
   - S'assurer que le serveur web a les droits de lecture sur tous les fichiers
   - Vérifier que le dossier `public/images/` est accessible

## 🔐 Comptes par défaut

### Administrateur
- **Login** : `lucas`
- **Mot de passe** : `123`

### Client de test
- **Email** : `lucas.gonz2702@gmail.com`
- **Mot de passe** : `lucas27022005`

> ⚠️ **Important** : Changez ces identifiants en production !

## 📖 Utilisation

### Accès à l'application

- **Page d'accueil** : `http://localhost/GonzBoutikV9/`
- **Administration** : Connectez-vous avec un compte administrateur

### Navigation

L'application utilise un système de routage basé sur les paramètres GET :
- `?controleur=Produits&action=afficher` : Affiche les produits
- `?controleur=Panier&action=afficher` : Affiche le panier
- `?controleur=Admin&action=...` : Actions d'administration

## 🗄️ Base de données

La base de données contient les tables suivantes :
- `admin` : Comptes administrateurs
- `client` : Comptes clients
- `produit` : Catalogue de produits
- `categorie` : Catégories de produits
- `marque` : Marques de smartphones
- `commande` : Commandes clients
- `lignecommande` : Détails des commandes
- `fournisseur` : Fournisseurs

### Procédures stockées

- `_GetAllClients()` : Récupère tous les clients
- `_GetAllProduits()` : Récupère tous les produits

### Fonctions

- `_GetTotalProduits()` : Retourne le nombre total de produits

### Déclencheurs (Triggers)

- `before_client_insert` : Vérifie l'unicité de l'email avant insertion
- `before_client_update` : Vérifie l'unicité de l'email avant mise à jour

## 🔧 Configuration

### Chemins de l'application

Les chemins sont définis dans `configs/chemins.class.php`. Modifiez-les si nécessaire selon votre structure de dossiers.

### Variables globales

Les variables globales sont définies dans `configs/variables_globales.class.php`.

## 🐛 Dépannage

### Problèmes courants

1. **Erreur de connexion à la base de données**
   - Vérifiez les paramètres dans `mysql_config.class.php`
   - Assurez-vous que MySQL est démarré
   - Vérifiez que la base de données existe

2. **Images non affichées**
   - Vérifiez que le dossier `public/images/` existe et est accessible
   - Vérifiez les chemins dans `chemins.class.php`

3. **Erreurs de session**
   - Vérifiez que `session_start()` est appelé dans `index.php`
   - Vérifiez les permissions d'écriture du dossier de session PHP

## 📝 Notes de développement

- L'application utilise l'architecture MVC pour une séparation claire des responsabilités
- Les requêtes SQL utilisent PDO avec des requêtes préparées pour la sécurité
- Les mots de passe sont stockés en clair (à améliorer en production avec un hachage)
- Le panier utilise les sessions PHP

## 🔒 Sécurité

⚠️ **Avertissements pour la production** :
- Hacher les mots de passe (utiliser `password_hash()` et `password_verify()`)
- Utiliser HTTPS
- Valider et échapper toutes les entrées utilisateur
- Implémenter une protection CSRF
- Limiter les tentatives de connexion
- Utiliser des requêtes préparées (déjà en place)

## 📄 Licence

Ce projet est un projet éducatif/développement personnel.

## 👤 Auteur

Développé par Lucas Gonzalez

## 📞 Support

Pour toute question ou problème, veuillez ouvrir une issue sur le dépôt du projet.

---

**Version** : 9.0  
**Dernière mise à jour** : 2025

