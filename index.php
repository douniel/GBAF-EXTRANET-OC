<?php

session_start();

require 'function.php';

if (isset($_SESSION['auth']['username'])) {
  header('Location: acteurs.php');
  exit;
}


$error = 0;
$msgError = [];

if (!empty($_POST['connection'])) {

    if (empty($_POST['username'])) {
        $msgError['username'] = "Le pseudo est vide";
        $error++;
    }
    if (empty($_POST['password'])) {
        $msgError['password'] = "Le mot de passe est vide";
        $error++;
    }

    if ($error === 0) {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        //requete sql pour récupérer le compte lié au pseudo donné
        $resultat = getAccount($username);

        if ($resultat)
        {
            $isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);
            if ($isPasswordCorrect) {

                $_SESSION['auth']['id'] = $resultat['id'];
                $_SESSION['auth']['username'] = $resultat['username'];
                $_SESSION['auth']['lastname'] = $resultat['lastname'];
                $_SESSION['auth']['firstname'] = $resultat['firstname'];
                $_SESSION['auth']['question'] = $resultat['question'];
                $_SESSION['auth']['answer'] = $resultat['answer'];

                $_SESSION['msg'] = 'Vous êtes connecté';
                header('Location: acteurs.php');
                exit;
            } else {
                $_SESSION['msg'] = 'Mauvais identifiants';
            }
        } else {
            $_SESSION['msg'] = 'Mauvais identifiants';
        }

    }

}

?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Page de connexion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/tablett.css" media="screen and (min-width: 425px)">
    <link rel="stylesheet" type="text/css" href="css/desktop.css" media="screen and (min-width: 769px)">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100&display=swap" rel="stylesheet">
  </head>
  <body>

        <?php if (isset($_SESSION['msg'])) : ?>

          <p><?= $_SESSION['msg']; unset($_SESSION['msg']); ?></p>

        <?php endif; ?>

    <!-- SECTION HEADER -->
    <header>
    <section id="header-site">
      <div class="content-header">
        <div>
          <p><img class="img-logo" src="images/GBAF.png" alt="Logo"></p>
        </div>
        <div class="content-user">
          <img class="img-user" src="images/user.png" alt="utilisateur">
          <p>Nom / Pr&eacutenom</p>
        </div>
      </div>
    </section>
    </header>

    <h1>CONNEXION:</h1>

      <form method="post">

        <p>
          <label for="username">PSEUDO : </label>
          <input class="username" type="text" name="username" id="username" value="<?= !empty($_POST['username']) ? $_POST['username'] : '' ?>" />
          <p class="<?= !empty($msgError['username']) ? 'dblock' : 'dnone' ?>"><?= !empty($msgError['username']) ? $msgError['username'] : '' ?></p>
        </p>

        <p>
          <label for="password">MOT DE PASSE : </label>
          <input class="password1" type="password" name="password" id="password" />
          <p class="<?= !empty($msgError['password']) ? 'dblock' : 'dnone' ?>"><?= !empty($msgError['password']) ? $msgError['password'] : '' ?></p>
        </p>

        <input type="submit" value="Se connecter" name="connection">


      </form>
      <br />
      <a href="forgotten_password.php">Mot de passe oublié ?</a><br />
      <a href="register.php">Pas encore inscrit ? Créez votre compte </a>

  </body>
</html>