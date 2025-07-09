<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription</title>
  <style>
    .containerCo {
      max-width: 600px;
      margin: 50px auto;
      text-align: center;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
      padding: 20px;
    }

    h5 {
      font-size: 28px;
      color: #000;
      font-weight: 600;
      margin-bottom: 20px;
    }

    .form-container {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      justify-content: space-between;
    }

    .form-group {
      width: 48%;
      text-align: left;
    }

    .full-width {
      width: 100%;
    }

    input {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 2px solid black;
      border-radius: 9px;
    }

    input:focus {
      border-color: rgb(24, 25, 25);
      outline: none;
      box-shadow: 0 0 5px rgba(27, 39, 50, 0.5);
    }

    .buttonCo {
      width: 100%;
      padding: 14px;
      font-size: 16px;
      background: rgb(11, 12, 13);
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.3s;
      margin-top: 15px;
    }

    .buttonCo:hover {
      background: rgb(41, 43, 44);
    }

    .is-invalid {
      border-color: red;
    }

    .error-message {
      color: red;
      font-size: 14px;
      display: none;
    }

    .checkbox-container {
      text-align: left;
      margin-top: 10px;
    }

    .error-message {
      color: red;
      font-size: 14px;
      margin-top: 5px;
    }


    /* Responsive */
    @media (max-width: 768px) {
      .containerCo {
        width: 90%;
        padding: 10px;
      }

      .form-container {
        flex-direction: column;
      }

      .form-group {
        width: 100%;
      }
    }
  </style>
</head>

<body>

  <div class="containerCo">
    <h5>Créez votre compte</h5>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger" style="color: red; background-color: #ffebee; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
        <?php 
          echo htmlspecialchars($_SESSION['error']);
          unset($_SESSION['error']);
        ?>
      </div>
    <?php endif; ?>

    <form id="formInscription" method="post" action="index.php?controleur=Connexion&action=inscrireClient">
      <div class="form-container">
        <div class="form-group">
          <label>Prénom</label>
          <input type="text" id="prenom" name="prenom" placeholder="Entrez votre prénom" required>
          <div class="error-message">Veuillez entrer votre prénom.</div>
        </div>

        <div class="form-group">
          <label>Nom</label>
          <input type="text" id="nom" name="nom" placeholder="Entrez votre nom" required>
          <div class="error-message">Veuillez entrer votre nom.</div>
        </div>

        <div class="form-group">
          <label for="email">E-mail</label>
          <input type="email" id="email" name="email" placeholder="Entrez votre e-mail" required>

          <!-- Affichage de l'erreur sous le champ e-mail -->
          <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message" style="color: red; font-size:14px;">
              <?php 
                echo htmlspecialchars($_SESSION['error']);
                unset($_SESSION['error']); // Supprime le message après l'avoir affiché
              ?>
            </div>
          <?php endif; ?>
        </div>

        <div class="form-group">
          <label>Mot de passe</label>
          <input type="password" id="mdp" name="mdp" placeholder="Entrez votre mot de passe" required>
          <div class="error-message" id="mdpError">Le mot de passe doit comporter au moins 12 caractères.</div>
        </div>

        <div class="form-group full-width">
          <label>Adresse</label>
          <input type="text" id="rue" name="rue" placeholder="Entrez votre adresse" required>
          <div class="error-message">Veuillez entrer votre adresse.</div>
        </div>

        <div class="form-group">
          <label>Ville</label>
          <input type="text" id="ville" name="ville" placeholder="Entrez votre ville" required>
          <div class="error-message">Veuillez entrer votre ville.</div>
        </div>

        <div class="form-group">
          <label>Code postal</label>
          <input type="text" id="codePostal" name="codePostal" placeholder="Entrez votre code postal" required>
          <div class="error-message">Veuillez entrer un code postal valide.</div>
        </div>

        <div class="form-group full-width">
          <label>Numéro de téléphone</label>
          <input type="tel" id="tel" name="tel" placeholder="Entrez votre numéro de téléphone" required>
          <div class="error-message">Veuillez entrer un numéro de téléphone valide.</div>
        </div>

        <div class="form-group full-width checkbox-container">
          <input type="checkbox" id="conditions" name="conditions">
          <label for="conditions">J'accepte les <a href="#">conditions générales</a></label>
          <div class="error-message" id="errorConditions">Vous devez accepter les conditions générales.</div>
        </div>
      </div>

      <button class="buttonCo" type="submit">S'inscrire</button>
    </form>

    <div class="signup-link">
      <p>Vous avez déjà un compte ? <a href="index.php?controleur=Connexion&action=afficherCompteClient">Connectez-vous</a></p>
    </div>
  </div>

  <script>
    $(document).ready(function() {
        $('#formInscription').on('submit', function(event) {
            let isValid = true;

            // Vérification des champs obligatoires
            $(this).find('input[required]').each(function() {
                let $input = $(this);
                let $errorDiv = $input.next('.error-message');
                
                if ($input.val().trim() === '') {
                    $input.addClass('is-invalid');
                    $errorDiv.show();
                    isValid = false;
                } else {
                    $input.removeClass('is-invalid');
                    $errorDiv.hide();
                }
            });

            // Vérification du mot de passe
            let $mdp = $('#mdp');
            let $mdpError = $('#mdpError');
            if ($mdp.val().length < 12) {
                $mdp.addClass('is-invalid');
                $mdpError.show();
                isValid = false;
            } else {
                $mdp.removeClass('is-invalid');
                $mdpError.hide();
            }

            // Vérification des conditions générales
            let $conditions = $('#conditions');
            let $errorConditions = $('#errorConditions');
            if (!$conditions.is(':checked')) {
                $errorConditions.show();
                isValid = false;
            } else {
                $errorConditions.hide();
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    });
  </script>

</body>

</html>

