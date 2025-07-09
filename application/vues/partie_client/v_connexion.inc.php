<style>
    .containerCo {
        width: 500px;
        margin: 50px auto;
        text-align: center;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }

    h5 {
        font-size: 28px;
        color: #000;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .form-group {
        position: relative;
        margin-bottom: 18px;
        text-align: left;
    }

    input {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        border: 2px solid black;
        border-radius: 9px;
    }

    input:focus {
        border-color:rgb(24, 25, 25);
        outline: none;
        box-shadow: 0 0 5px rgba(27, 39, 50, 0.5);
    }

    .forgot-password {
        display: block;
        text-align: right;
        font-size: 14px;
        color:rgb(31, 32, 32);
        text-decoration: none;
        margin-top: 5px;
    }

    .forgot-password:hover {
        text-decoration: underline;
    }

    .buttonCo {
        width: 100%;
        padding: 14px;
        font-size: 16px;
        background:rgb(11, 12, 13);
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .buttonCo:hover {
        background:rgb(41, 43, 44);
    }

    .signup-link {
        font-size: 14px;
        margin-top: 15px;
    }

    .signup-link a {
        color:rgb(38, 41, 45);
        text-decoration: none;
        font-weight: 600;
    }

    .signup-link a:hover {
        text-decoration: underline;
    }
</style>

<div class="containerCo">
    <h5>Connectez-vous pour régler vos achats plus rapidement.</h5>

    <?php if (isset($_GET['messageErreur'])): ?>
        <div class="alert" style="color: red; font-size: 14px;">
            <?php echo htmlspecialchars($_GET['messageErreur']); ?>
        </div>
    <?php endif; ?>

    <form method="post" action="index.php?controleur=Connexion&action=verifierConnexionClient">
        <div class="form-group">
            <label>Adresse mail</label>
            <input type="text" name="email" placeholder="Entrer votre email" required>
        </div>
        
        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="mdp" placeholder="Entrer votre mot de passe" required>
            <a href="auth-recoverpw.html" class="forgot-password">Mot de passe oublié ?</a>
        </div>

        <button class="buttonCo" type="submit">Se connecter</button>
    </form>

    <div class="signup-link">
        <p>Vous n'avez pas de compte ? <a href="index.php?controleur=Connexion&action=afficherFormulaireInscription">Créer un compte</a></p>
    </div>
</div>
